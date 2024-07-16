<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\Specialist;
use App\Models\Statistic;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_store_review() : void
    {
        $this->seed(TestSeeder::class);
        $user=User::factory()->create();
        $specialist=User::factory()->has(Specialist::factory())->create()->specialist;
        $specialist->statistic()->create();

        $statistic=$specialist->statistic()->create();
        $statistic->review_grade = 3;
        $statistic->save();

        $data=['text'=>'Some text','grade'=>2];
        $response = $this->actingAs($user)->post(route('review.store',[$specialist->id]),$data);
        $reviews = $user->reviews()->get();
        $review=$user->reviews()->first();

        $response->assertRedirect();       
        $this->assertCount(1,$reviews);
        $this->assertEquals($specialist->id, $review->specialist->id);
        $this->assertEquals($review->text,$data['text']);
        $this->assertEquals($review->grade,$data['grade']);
        $this->assertEquals($specialist->statistic->review_grade,$data['grade']);
    }

    public function test_user_can_delete_review() : void
    {
        $this->seed(TestSeeder::class);
        $user = User::first();
        $specialist=User::factory()->has(Specialist::factory())->create()->specialist;
        $statistic=$specialist->statistic()->create();
        $statistic->review_grade = 3;
        $statistic->save();

        $review= Review::factory()->make(['user_id'=>$user->id,'grade' => 3]);
        $specialist->reviews()->save($review);
        
        $response = $this->actingAs($user)->delete(route('review.destroy',[$review->id]));

        $response->assertRedirect();
        $this->assertModelMissing($review);
        $this->assertEquals($specialist->statistic->review_grade,0);
    }

    public function test_user_can_update_review() : void
    {
        $this->seed(TestSeeder::class);
        $user = User::first();
        $specialist=User::factory()->has(Specialist::factory())->create()->specialist;

        $statistic=$specialist->statistic()->create();
        $statistic->review_grade = 3;
        $statistic->save();

        $review= Review::factory()->make(['user_id'=>$user->id,'grade' => 2]);
        $specialist->reviews()->save($review);
        $data=['text'=>'Some text','grade'=>2];
    
        $response = $this->actingAs($user)->put(route('review.update',[$review->id]),$data);
        $review->refresh();

        $response->assertRedirect();
    
        $this->assertEquals($specialist->id, $review->specialist->id);
        $this->assertEquals($review->text,$data['text']);
        $this->assertEquals($review->grade,$data['grade']);
        $this->assertEquals($specialist->statistic->review_grade,$data['grade']);
    }
}