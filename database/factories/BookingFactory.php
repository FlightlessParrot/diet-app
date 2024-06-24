<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
    {

        $startDate = fake()->dateTimeInInterval('+1 week', '+3 days','Europe/Warsaw'); 
        $endDate = new DateTime($startDate->format('Y-m-d H:i:s'));
        $endDate->modify('+30 mins');

        return [
            'start_date'=>$startDate->format('Y-m-d H:i:s'),
            'end_date' => fake()->dateTime(),
        ];
    }
}
