<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_specialist_can_get_categories_form(): void
    {
        $this->seed();

        $user = User::has('specialist')->first();

        $response = $this->actingAs($user)->get(route('category.attach'));

        $response->assertStatus(200);
    }

    public function test_specialist_can_store_categories(): void
    {
        $this->seed();

        $user = User::has('specialist')->first();
        $specialist = $user->specialist;
        $categories=Category::all();
        $categoriesArray=[$categories[0]->id, $categories[1]->id];
        $response = $this->actingAs($user)->post(route('specialist.categories.store', $specialist->id),['categories' => $categoriesArray]);
        $specialist->refresh();
        $specialistCategories=$specialist->categories()->get();
        
        $response->assertRedirect(route('dashboard'));
        $this->assertCount(2, $specialistCategories);
        
    }
}
