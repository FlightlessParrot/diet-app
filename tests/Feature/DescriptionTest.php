<?php

namespace Tests\Feature;

use App\Models\Description;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DescriptionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_specialist_can_store_description(): void
    {
        $this->seed();
        $full=fake()->text();
        $short = fake()->sentence();
        $user = User::factory()->has(Specialist::factory())->create();
        $response = $this->actingAs($user)->post(route('description.store',[$user->specialist->id]),['full'=>$full,'short'=>$short]);
        
        $response->assertRedirect();
        $desc=$user->specialist->description;
        $this->assertModelExists($desc);
        $this->assertSame($full,$desc->full);
        $this->assertSame($short, $desc->short);
    }

    public function test_specialist_can_update_description(): void
    {
        $this->seed();
        $full=fake()->text();
        $short = fake()->sentence();
        $user = User::factory()->has(Specialist::factory()->has(Description::factory()))->create();
        $response = $this->actingAs($user)->put(route('description.update',[$user->specialist->id,$user->specialist->description->id]),['full'=>$full,'short'=>$short]);
        
        $response->assertRedirect();
        $desc=$user->specialist->description;
        $desc->refresh();
        
        $this->assertModelExists($desc);
        $this->assertSame($full,$desc->full);
        $this->assertSame($short, $desc->short);
    }
}
