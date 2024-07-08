<?php

namespace Tests\Feature;

use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatisticTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_found_count_increment(): void
    {
        $this->seed(TestSeeder::class);
        $user = User::first();
        $specialist = Specialist::first();
        $counter = $specialist->statistic->view_counter;

        $response = $this->actingAs($user)->get(route('specialist.visit',[$specialist->id]));

    
        $specialist->refresh();
        $this->assertSame($counter+1,$specialist->statistic->view_counter);
       
        $response->assertStatus(200);
    }
}
