<?php

namespace Database\Seeders;

use App\Events\BookingSet;
use App\Models\Anonym;
use App\Models\Booking;
use App\Models\Phone;
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
        foreach ($specialists as $specialist) {
            $booking = Booking::factory()->make();
            $specialist->bookings()->save($booking);
        }

        $users = User::all();
        foreach ($users as $user) {
            $booking = Booking::factory()->make(['status' => 'pending']);
            $booking->user_id = $user->id;
            $specialists->random(1)[0]->bookings()->save($booking);
            $booking->address()->associate($specialist->addresses()->first());
            $booking->save();
            BookingSet::dispatch($booking);
        }
        $bookings = Booking::factory(40)->make(['status' => 'pending']);
        foreach ($bookings as $booking) {

            $specialists->random(1)[0]->bookings()->save($booking);
            $booking->address()->associate($specialist->addresses()->first());
            $booking->save();
            $phone = Phone::factory()->make();
            $anonym = Anonym::factory()->create(['booking_id' => $booking->id]);
            $anonym->phone()->save($phone);
            BookingSet::dispatch($booking);
        }
        $shrimpUser = User::where('email', 'shrimpinweb@gmail.com')->first();
        if ($shrimpUser) {
            $shrimp = $shrimpUser->specialist;
            //user booking
            $booking = Booking::factory()->make(['status' => 'pending']);
            $booking->user_id = User::first()->id;
            $shrimp->bookings()->save($booking);
            $booking->address()->associate($specialist->addresses()->first());
            $booking->save();
            BookingSet::dispatch($booking);

            // anonym booking
            $booking = Booking::factory()->make(['status' => 'pending']);
            $shrimp->bookings()->save($booking);
            $booking->address()->associate($specialist->addresses()->first());
            $booking->save();
            $phone = Phone::factory()->make();
            $anonym = Anonym::factory()->create(['booking_id' => $booking->id]);
            $anonym->phone()->save($phone);
            BookingSet::dispatch($booking);
        }
    }
}
