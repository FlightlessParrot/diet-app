<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Payment;
use App\Models\Specialist;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        foreach(Specialist::all() as $specialist)
        {
            $payment = Payment::factory()->make();
            $payment->offer_id=Offer::where('duration',3)->firstOrFail()->id;
            $payment->ing_transaction_id=strval($specialist->id).'123';
            $subscription = Subscription::factory()->make();
            
            $specialist->payments()->save($payment);
            $subscription->payment_id=$payment->id;
            $subscription->save();


        }
    }
}
