<?php

namespace Tests\Feature\Supports;

use App\Models\Review;
use App\Models\Specialist;

use App\Models\User;
use App\Supports\Critic;
use Database\Seeders\MyRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CriticTest extends TestCase
{
    use RefreshDatabase;
    public function test_critic_can_get_reviews(): void
    {
        $this->seed([MyRolesSeeder::class]);
        $user = User::factory()->has(Specialist::factory()->has(Review::factory(4)))->create();
        $specialist = $user->specialist;
        $totalGrade=0;
        foreach($specialist->reviews()->get() as $review)
        {
            $totalGrade += $review->grade;
        }
        $avgGrade=(int) ceil($totalGrade/4);

        $critic = new Critic($specialist);
        $criticGrade = $critic->getAverageGrade();

        $this->assertEquals($avgGrade,$criticGrade);        
    }

    public function test_critic_can_save_grade(): void
    {
        $this->seed([MyRolesSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        $specialist->statistic()->create();
        $avgGrade=(int) 5;

        $critic = new Critic($specialist);
        $critic->saveGrade($avgGrade);

        $this->assertEquals($avgGrade,$specialist->statistic->review_grade);        
    }
    public function test_critic_can_get_criticize(): void
    {
        $this->seed([MyRolesSeeder::class]);
        $user = User::factory()->has(Specialist::factory()->has(Review::factory(4)))->create();
        $specialist = $user->specialist;
        $specialist->statistic()->create();
        $totalGrade=0;
        foreach($specialist->reviews()->get() as $review)
        {
            $totalGrade += $review->grade;
        }
        $avgGrade=(int) ceil($totalGrade/4);

        $critic = new Critic($specialist);
        $critic->criticize();

        $this->assertEquals($avgGrade,$specialist->statistic->review_grade);        
    }
}
