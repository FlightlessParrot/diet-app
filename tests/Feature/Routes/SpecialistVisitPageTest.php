<?php

namespace Tests\Feature\Routes;
use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpecialistVisitPageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_see_specialist_visit_page(): void
    {
        $this->seed(TestSeeder::class);
        $user = User::first();
        $specialist = Specialist::first();
        $response = $this->actingAs($user)->get(route('specialist.visit',[$specialist->id]))->assertInertia(fn (Assert $page) => $page
        ->component('User/SpecialistView')
        ->has('specialist'));
       
        $response->assertStatus(200);
    }
}
