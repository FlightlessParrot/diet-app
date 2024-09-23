<?php

namespace Tests\Feature\Routes;

use App\Models\Offer;
use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\MyRolesSeeder;
use Database\Seeders\OfferSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class OffersRoutesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_see_all_offers(): void
    {
        $this->seed([MyRolesSeeder::class,OfferSeeder::class]);
        $user = User::factory()->has(Specialist::factory())->create();
        $response = $this->actingAs($user)->get(route('offers.index'))->assertInertia(fn (Assert $page) => $page
        ->component('Specialist/Commerce/Offers')
        ->has('offers'));;
        
        $response->assertStatus(200);
    }

    public function test__user_can_see_chosen_offer(): void
    {
        $this->seed([MyRolesSeeder::class,OfferSeeder::class]);
        $offer = Offer::firstOrFail();
        $user = User::factory()->has(Specialist::factory())->create();
        $response = $this->actingAs($user)->get(route('offer.show',[$offer->id]))->assertInertia(fn (Assert $page) => $page
        ->component('Specialist/Commerce/Offer')
        ->has('offer'));

        $response->assertStatus(200);
    }

}
