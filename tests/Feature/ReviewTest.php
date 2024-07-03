<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\Specialist;
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
        $specialist=Specialist::firstOrFail();
        $data=['text'=>'Some text','grade'=>2];
        $response = $this->actingAs($user)->post(route('review.store',[$specialist->id]),$data);
        $reviews = $user->reviews()->get();
        $review=$user->reviews()->first();

        $response->assertRedirect();       
        $this->assertCount(1,$reviews);
        $this->assertEquals($specialist->id, $review->specialist->id);
        $this->assertEquals($review->text,$data['text']);
        $this->assertEquals($review->grade,$data['grade']);
    }

    public function test_user_can_delete_review() : void
    {
        $this->seed(TestSeeder::class);
        $review = Review::first();
        $user=$review->user;
        $response = $this->actingAs($user)->delete(route('review.destroy',[$review->id]));

        $response->assertRedirect();
        $this->assertModelMissing($review);
    }

    public function test_user_can_update_review() : void
    {
        $this->seed(TestSeeder::class);
        $review = Review::firstOrFail();
        $data=['text'=>'Some text','grade'=>2];
        $user=$review->user;
        $specialist=$review->specialist;

        $response = $this->actingAs($user)->put(route('review.update',[$review->id]),$data);
        $review->refresh();

        $response->assertRedirect();
    
        $this->assertEquals($specialist->id, $review->specialist->id);
        $this->assertEquals($review->text,$data['text']);
        $this->assertEquals($review->grade,$data['grade']);
    }
}