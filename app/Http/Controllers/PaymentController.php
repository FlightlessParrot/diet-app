<?php

namespace App\Http\Controllers;

use App\Events\PaymentAccepted;
use App\Events\PaymentRejected;
use App\Models\Address;
use App\Models\Discount;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\Subscription;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class PaymentController extends Controller
{

    public function create()
    {

        return Inertia::render('Specialist/Commerce/Payment');
    }

    public function success()
    {
        return Inertia::render('Specialist/Commerce/PaymentAccepted');
    }

    public function fail()
    {
        return Inertia::render('Specialist/Commerce/PaymentRejected');
    }

    public function buy(Offer $offer, ?string $code=null)
    {
        $user = Auth::user();
        $specialist = $user->specialist;
        $address = $specialist->addresses()->firstOrFail();
        if (!$offer) {
            return redirect()->to_route('offers.index')->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }    

        $payment = new Payment();
        $payment->price = $offer->price;
        if(isset($code))
        {
            $discount = Discount::queryAvailableDiscounts()->where('code',$code)->first();
            if(isset($discount))
            {
                $payment->price=$payment->price - ($payment->price*$discount->amount/100);
                $payment->discount_id=$discount->id;
            }
        }
        $payment->offer_id = $offer->id;
        Auth::user()->specialist->payments()->save($payment);
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . env('PAYMENT_TOKEN'),
            'Content-Type' => 'application/json',

        ])->post(
            'https://sandbox.api.imoje.pl/v1/merchant/' . env('MERCHANT_ID') . '/transaction',
            [
                "type" => "sale",
                "serviceId" => env('SHOP_ID'),
                "amount" => intval($payment->price * 100),
                "title" => $offer->name,
                "currency" => "PLN",
                "orderId" => strval($payment->id),
                "paymentMethod" => "pbl",
                "paymentMethodCode" => "ipko",
                "successReturnUrl" => route('payment.success'),
                "failureReturnUrl" => route('payment.fail'),
                "customer" => [
                    "firstName" => $specialist->name,
                    "lastName" => $specialist->surname,
                    "email" => $user->email,
                    "phone" => $specialist->phone->number
                ],

                "billing" => [
                    "firstName" => $specialist->name,
                    "lastName" => $specialist->surname,
                ],
                "invoice" =>[
                    'buyer'=>[ 
                        
                    'type'=> 'PERSON',
                    'email'=>$user->email,
                    'fullName'=>$specialist->name.' '.$specialist->surname,
                    'street' =>  $address->line_1.' '.$address->line_2,
                    'city' =>$address->city,
                    'postalCode' => strval($address->code),
                    'countryCodeAlpha2'=>'PL'

                ],
                'positions'=>[
                    ['name'=>$offer->name,
                    'code'=>strval($payment->id),
                    'quantity'=>1,
                    'unit'=>'license',
                    'grossAmount'=>intval($offer->price * 100),
                    'taxStake'=>'TAX_NOT_LIABLE',
                    ]
                ]]
            ]
        )->throwUnlessStatus(200)->json();
        $payment->ing_transaction_id = $response['transaction']['id'];
        $payment->save();
        
        return redirect($response['action']['url']);
    }

    public function notify(Request $request)
    {
        $transactionId=$request->input('transaction.id');
        $payment=Payment::where('ing_transaction_id',$transactionId)->firstOrFail();
        $status =$request->input('transaction.status');
        if($status==='settled')
        {
            $payment->status='accepted';
            $payment->save();
            
            $offer = Offer::withTrashed()->find($payment->offer_id);
            $specialist = $payment->specialist;
            $currentSubscription = $specialist->activeSubscription();
            $subscription= new Subscription();
            $start_date=new DateTime();
            if($currentSubscription)
            {
                $start_date=new \DateTime($currentSubscription->end_date);
                $start_date->modify('+1 day');
                $start_date->setTime(0,0,0,0);
                $subscription->start_date=$start_date->format('Y-m-d H:i:s');
            }else{
                $start_date=new \DateTime();
                $start_date->setTime(0,0,0,0);
                $subscription->start_date=$start_date->format('Y-m-d H:i:s');
            }
            $end_date=new DateTime($start_date->format('Y-m-d H:i:s'));
            $end_date->modify(strval($offer->duration).' months'); 
            $end_date->setTime(23,59,59,59);
            $subscription->end_date=$end_date->format('Y-m-d H:i:s');
            $subscription->payment_id=$payment->id;
            $subscription->save();
            PaymentAccepted::dispatch($payment);
            return response(['status'=>'ok']);
        } 
        if($status==='cancelled' || $status==='rejected')
        {
            $payment->status='rejected';
            $payment->save();
            PaymentRejected::dispatch($payment);
            return response(['status'=>'ok']);
        }
        if($status==='pending' || $status==='new')
        {
            $payment->status='pending';
            $payment->save();
            return response(['status'=>'ok']);
        }
        
        return Response('Unknown status.',500);
    }

 
}
