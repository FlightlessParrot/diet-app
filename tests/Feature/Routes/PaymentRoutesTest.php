<?php

namespace Tests\Feature;
use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\MyRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentRoutesTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_see_success_message(): void
    {
        $this->seed([MyRolesSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();
        $response = $this->actingAs($user)->get(route('payment.success'))->assertInertia(fn (Assert $page) => $page
        ->component('Specialist/Commerce/PaymentAccepted'));
  

        $response->assertStatus(200);
    }

    public function test_user_can_see_failure_message(): void
    {
        $this->seed([MyRolesSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();
        $response = $this->actingAs($user)->get(route('payment.fail'))->assertInertia(fn (Assert $page) => $page
        ->component('Specialist/Commerce/PaymentRejected'));
  

        $response->assertStatus(200);
    }
}
