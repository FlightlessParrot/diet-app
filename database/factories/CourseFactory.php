<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date=fake()->date('Y-m-d');
        $start = new DateTime($date);
        $end = new DateTime();
        return [
            'name'=>fake()->words(3, true),
            'start_date'=>$start->format('Y-m-d'),
            'end_date'=>$end->format('Y-m-d')
        ];
    }
}
