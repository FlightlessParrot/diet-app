<?php

namespace Tests\Feature;

use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\MyRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowersTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_add_specialist_to_favourite(): void
    {
        $this->seed(MyRolesSeeder::class);
        $user= User::factory()->create();
        $specialist = User::factory()->has(Specialist::factory())->create()->specialist;
        $response = $this->from('example/url')->actingAs($user)->post(route('follow.specialist',[$specialist->id]));
             
        $response->assertRedirect('example/url');
        $this->assertNotNull($user->favouriteSpecialists()->find($specialist->id));
    }

    public function test_user_can_remove_specialist_rom_favourite(): void
    {
        $this->seed(MyRolesSeeder::class);
        $user= User::factory()->create();
        $specialist = User::factory()->has(Specialist::factory())->create()->specialist;
        $user->favouriteSpecialists()->attach($specialist);
        $response = $this->from('example/url')->actingAs($user)->delete(route('unfollow.specialist',[$specialist->id]));

        $response->assertRedirect('example/url');
        $this->assertNull($user->favouriteSpecialists()->find($specialist->id));
    }
}
