<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Specialist;
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
    }
}
