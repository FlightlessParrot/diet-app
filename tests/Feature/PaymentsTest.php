<?php

namespace Tests\Feature;

use App\Models\MyRole;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\Specialist;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\MyRolesSeeder;
use Database\Seeders\OfferSeeder;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentsTest extends TestCase
{
    use RefreshDatabase;
    public function test_app_send_correct_transaction_request(): void
    {
        $this->seed([TestSeeder::class]);
        Http::fake([
            'https://sandbox.api.imoje.pl/*' => Http::response([
                'transaction' => ['id' => '123'],
                'action' => ['url' => route('dashboard')]
            ]),
            'https://api.imoje.pl/*' => Http::response(['transaction' => ['id' => '123']])
        ]);
        $user = User::has('specialist')->first();
        foreach ($user->specialist->payments()->get() as $payment) {
            $payment->delete();
        }
        $offer = Offer::firstOrFail();
        $response = $this->actingAs($user)->get(route('payment.buy', $offer))->assertRedirectToRoute('dashboard');
        $payment = $user->specialist->payments()->first();
        $this->assertNotNull($payment);
        $this->assertEquals($payment->ing_transaction_id, '123');
    }

    public function test_app_can_receive_notification()
    {
        $this->seed([MyRolesSeeder::class, OfferSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        $offer = Offer::firstOrFail();
        $offer->duration = 1;
        $offer->save();
        $payment = new Payment();
        $payment->price = $offer->price;
        $payment->offer_id = $offer->id;
        $payment->ing_transaction_id = '123';
        $specialist->payments()->save($payment);

        $response = $this->from('http://example.pl')->postJson('/payment/notifications', ['transaction' => [
            'id' => 123,
            'status' => 'settled',
        ]])->assertStatus(200)->assertJson(['status' => 'ok']);

        $payment->refresh();
        $subscription = $payment->subscription;
        $start_date = new \DateTime();
        $start_date->setTime(0,0,0,0);
        $end_date=new \DateTime($start_date->format('Y-m-d H:i:s'));
        $end_date->modify('+1 month');
        $end_date->setTime(23,59,59,59);
        $this->assertEquals($payment->status, 'accepted');
        $this->assertNotNull($subscription);
        $this->assertEquals($subscription->start_date, $start_date->format('Y-m-d H:i:s'));
        $this->assertEquals($subscription->end_date, $end_date->format('Y-m-d H:i:s'));
    }

    public function test_app_can_extend_subscription()
    {
        $this->seed([MyRolesSeeder::class, OfferSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;

        $pre_start_date = new \DateTime();
        $pre_start_date->setTime(0,0,0,0);
        $pre_end_date=new \DateTime($pre_start_date->format('Y-m-d H:i:s'));
        $pre_end_date->modify('+1 months');
        $pre_end_date->setTime(23,59,59,59);

        $offer = Offer::firstOrFail();
        $offer->duration = 1;
        $offer->save();


        $dpayment = new Payment();
        $dpayment->price = $offer->price;
        $dpayment->offer_id = $offer->id;
        $dpayment->ing_transaction_id = '1234';
        $specialist->payments()->save($dpayment);
        $subscription=new Subscription();
        $subscription->start_date=$pre_start_date;
        $subscription->end_date=$pre_end_date;
        $subscription->payment_id=$dpayment->id;
        $subscription->save();  $pre_end_date->modify('+1 day');


        $payment = new Payment();
        $payment->price = $offer->price;
        $payment->offer_id = $offer->id;
        $payment->ing_transaction_id = '123';
        $specialist->payments()->save($payment);

        $response = $this->from('http://example.pl')->postJson('/payment/notifications', ['transaction' => [
            'id' => 123,
            'status' => 'settled',
        ]])->assertStatus(200)->assertJson(['status' => 'ok']);

        $payment->refresh();
        $subscription = $payment->subscription;
      
        $start_date = new \DateTime($pre_end_date->format('Y-m-d H:i:s'));
        $start_date->setTime(0,0,0,0);
        $end_date=new \DateTime($start_date->format('Y-m-d H:i:s'));
        $end_date->modify('+1 months');
        $end_date->setTime(23,59,59,59);
        $this->assertEquals($payment->status, 'accepted');
        $this->assertNotNull($subscription);
        $this->assertEquals($subscription->start_date, $start_date->format('Y-m-d H:i:s'));
        $this->assertEquals($subscription->end_date, $end_date->format('Y-m-d H:i:s'));
    }


    public function test_app_can_understand_cancelled_status()
    {
        $this->seed([MyRolesSeeder::class, OfferSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        $offer=Offer::firstOrFail();

        $payment = new Payment();
        $payment->price = $offer->price;
        $payment->offer_id = $offer->id;
        $payment->ing_transaction_id = '123';
        $specialist->payments()->save($payment);

        $response = $this->from('http://example.pl')->postJson('/payment/notifications', ['transaction' => [
            'id' => 123,
            'status' => 'cancelled',
        ]])->assertStatus(200)->assertJson(['status' => 'ok']);

        $payment->refresh();
        $subscription = $payment->subscription;
    
        $this->assertEquals($payment->status, 'rejected');
        $this->assertNull($subscription);
     
    }

    public function test_app_can_understand_rejected_status()
    {
        $this->seed([MyRolesSeeder::class, OfferSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        $offer=Offer::firstOrFail();

        $payment = new Payment();
        $payment->price = $offer->price;
        $payment->offer_id = $offer->id;
        $payment->ing_transaction_id = '123';
        $specialist->payments()->save($payment);

        $response = $this->from('http://example.pl')->postJson('/payment/notifications', ['transaction' => [
            'id' => 123,
            'status' => 'rejected',
        ]])->assertStatus(200)->assertJson(['status' => 'ok']);

        $payment->refresh();
        $subscription = $payment->subscription;
    
        $this->assertEquals($payment->status, 'rejected');
        $this->assertNull($subscription);
    }

    public function test_app_can_understand_new_status()
    {
        $this->seed([MyRolesSeeder::class, OfferSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        $offer=Offer::firstOrFail();

        $payment = new Payment();
        $payment->price = $offer->price;
        $payment->offer_id = $offer->id;
        $payment->ing_transaction_id = '123';
        $specialist->payments()->save($payment);

        $response = $this->from('http://example.pl')->postJson('/payment/notifications', ['transaction' => [
            'id' => 123,
            'status' => 'new',
        ]])->assertStatus(200)->assertJson(['status' => 'ok']);

        $payment->refresh();
        $subscription = $payment->subscription;
    
        $this->assertEquals($payment->status, 'pending');
        $this->assertNull($subscription);
     
    }

    public function test_app_can_understand_pending_status()
    {
        $this->seed([MyRolesSeeder::class, OfferSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        $offer=Offer::firstOrFail();

        $payment = new Payment();
        $payment->price = $offer->price;
        $payment->offer_id = $offer->id;
        $payment->ing_transaction_id = '123';
        $specialist->payments()->save($payment);

        $response = $this->from('http://example.pl')->postJson('/payment/notifications', ['transaction' => [
            'id' => 123,
            'status' => 'pending',
        ]])->assertStatus(200)->assertJson(['status' => 'ok']);

        $payment->refresh();
        $subscription = $payment->subscription;
    
        $this->assertEquals($payment->status, 'pending');
        $this->assertNull($subscription);
     
    }
    public function test_app_return_error_when_status_unknown()
    {
        $this->seed([MyRolesSeeder::class, OfferSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        $offer=Offer::firstOrFail();

        $payment = new Payment();
        $payment->price = $offer->price;
        $payment->offer_id = $offer->id;
        $payment->ing_transaction_id = '123';
        $specialist->payments()->save($payment);

        $response = $this->from('http://example.pl')->postJson('/payment/notifications', ['transaction' => [
            'id' => 123,
            'status' => 'unknwon',
        ]])->assertStatus(500);
    }
    public function test_app_return_error_when_payment_unknown()
    {
        $this->seed([MyRolesSeeder::class, OfferSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();

        $response = $this->from('http://example.pl')->postJson('/payment/notifications', ['transaction' => [
            'id' => 123,
            'status' => 'pending',
        ]])->assertStatus(404);
    }
}
