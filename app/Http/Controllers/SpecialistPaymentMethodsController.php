<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecialistPaymentMethodsRequest;
use App\Models\Specialist;
use App\Models\SpecialistPaymentMethod;
use Illuminate\Http\Request;

class SpecialistPaymentMethodsController extends Controller
{
    public function __invoke(SpecialistPaymentMethodsRequest $request)
    {
        $user = $request->user();
        $specialist=$user->specialist;
        $newMethods=$request->paymentMethods;
        
        $payments=$specialist->paymentMethods()->get();

        foreach($payments as $paymentMethod)
        {
            if(!in_array($paymentMethod->name,$newMethods))
            {
                $paymentMethod->delete();
            }        
        }
        foreach($newMethods as $name)
        {
        
        if(!$payments->where('name',$name)->first()){
            $paymentMethod = new SpecialistPaymentMethod();
            $paymentMethod->name=$name;
        
            $specialist->paymentMethods()->save($paymentMethod);
        }
        
        }
        
        return redirect()->back()->with('message', ['text' => 'Udało się ustalić metody płaności.', 'status' => 'success']);
    }

}
