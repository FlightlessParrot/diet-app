<?php

namespace Tests\Feature\Routes;

use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CreateLanguagesRouteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_specialist_can_see_languages_specialist_register_pages(): void
    {
        $this->seed(TestSeeder::class);
        $user=User::has('specialist')->firstOrFail();
        $languagesNumer=count($user->specialist->languages()->get());
        $response = $this->actingAs($user)->get(route('language.create'));

        $response->assertStatus(200)->assertInertia(fn (AssertableInertia $page) => $page
        ->component('Specialist/SetLanguages')
        ->has('languages',$languagesNumer));
    }
}
