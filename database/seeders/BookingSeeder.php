<?php

namespace Database\Seeders;

use App\Events\BookingSet;
use App\Models\Booking;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     
    public function run(): void
    {
       $specialists = Specialist::all();
       foreach($specialists as $specialist)
       {
        $booking = Booking::factory()->make();
        $specialist->bookings()->save($booking);
       }
       
       $users = User::all();
       foreach($users as $user)
       {
        $booking = Booking::factory()->make(['status'=>'pending']);
        $booking->user_id=$user->id;
        $specialists->random(1)[0]->bookings()->save($booking);
        $booking->address()->associate($specialist->addresses()->first());
        $booking->save();
        BookingSet::dispatch($booking);
       }
    }
}
