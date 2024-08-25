<?php

namespace Tests\Feature;

use App\Models\Specialist;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavouritePriceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test specialist can associate favourite price
     */
    public function test_specialist_can_associate_favourite_price(): void
    {
        $this->seed(TestSeeder::class);
        $specialist = Specialist::has('prices')->firstOrFail();
        $price = $specialist->prices()->firstOrFail();
        $response = $this->from('example/url')->actingAs($specialist->user)
        ->post(route('favourite.price.associate',[$price->id]));
        $specialist->refresh();
        $response->assertRedirect('example/url')->assertSessionHas('message', ['text' => 'Wybrano cenę.', 'status' => 'success']);
        $this->assertModelExists($specialist->favouritePrice)
        ->assertEquals($specialist->favouritePrice->id,$price->id);
    }
}
