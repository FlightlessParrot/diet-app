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
    public function test_specialist_can_update_categories(): void
    {
        $this->seed();

        $user = User::has('specialist')->first();
        $specialist = $user->specialist;
        $categories=Category::all();
        $specialist->categories()->attach($categories[0]->id);
        $specialist->categories()->attach($categories[1]->id);
        $categoriesArray=[$categories[2]->id, $categories[3]->id];

        $response = $this->actingAs($user)->from(route('specialist.profile.edit',$specialist->id))->put(route('specialist.categories.update', $specialist->id),['categories' => $categoriesArray]);
        $specialist->refresh();
        $specialistCategories=$specialist->categories()->get();
        
        $response->assertRedirect(route('specialist.profile.edit',$specialist->id));
        $this->assertCount(2, $specialistCategories);
        $this->assertModelExists($specialist->categories()->find($categoriesArray[0]));
        $this->assertModelExists($specialist->categories()->find($categoriesArray[1]));
        $this->assertNull($specialist->categories()->find($categories[0]->id));
        $this->assertNull($specialist->categories()->find($categories[1]->id));
        
    }
}
