<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialists=Specialist::all();
        foreach($specialists as $key => $specialist)
        {
            if($key%2===0)
            {
                $review = Review::factory()->make(['user_id'=>User::all()->random()]);
                $specialist->reviews()->save($review);
            }
        }
    }
}
