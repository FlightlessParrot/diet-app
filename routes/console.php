<?php

use App\Events\BookingIsComming;
use App\Models\Booking;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function (){
    
    $tomorrow = new DateTime();
    $tomorrow->modify('+1 day');
    $twoDaysLater=new DateTime();
    $twoDaysLater->modify('+2 days');
    $bookings=Booking::where('start_date','>',$tomorrow->format('Y-m-d H:i:s'))
    ->where('start_date','<',$twoDaysLater->format('Y-m-d H:i:s'))
    ->has('user')->get();
    foreach($bookings as $booking)
    {
        BookingIsComming::dispatch($booking);
    }

})->dailyAt('12:30');