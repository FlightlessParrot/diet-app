<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\ServiceCity;
use App\Models\ServiceKind;
use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class FindSpecialistTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TestSeeder::class);
    }
    /**
     * A basic feature test example.
     */
    public function test_user_can_see_find_specialists_page(): void
    {
        $user = User::first();
        $response = $this->actingAs($user)->get(route('specialist.index'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $page)  => $page
                ->component('User/FindSpecialist')
        );
    }

    public function test_user_can_find_specialist(): void
    {
        $user = User::first();
        $specialist = User::factory()->has(Specialist::factory()->has(ServiceKind::factory())->has(Category::factory()))
        ->create()->specialist;
        $response = $this->actingAs($user)->get(route('specialist.index', 
        [
            'searchTerm' => $specialist->name, 
            'categories' => [$specialist->categories()->first()->id], 
            'services' => [$specialist->serviceKinds()->first()->id]
        ]));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $page)  => $page
                ->component('User/FindSpecialist')
                ->has('paginatedSpecialists.data.0', fn (Assert $page) => $page
                    ->where('id', $specialist->id)
                    ->etc()
                    )   
        );
    }

    public function test_user_can_find_specialist_by_city_name(): void
    {
        $user = User::first();
        $specialist = User::factory()->has(Specialist::factory()->has(ServiceCity::factory()))->create()->specialist;
        $response = $this->actingAs($user)->get(route('specialist.index', 
        [
            'searchTerm' => $specialist->serviceCities()->first()->name, 
        ]));

        $response->assertStatus(200);
        //$responseSpecialistId = $response['props']['paginatedSpecialists']['data'][0]->id;
        $response->assertInertia(
            fn (Assert $page)  => $page
                ->component('User/FindSpecialist')
                ->has('paginatedSpecialists.data.0', fn (Assert $page) => $page
                    ->where('id', $specialist->id)
                    ->etc()
                    )   
        );
    }

    public function test_user_cant_find_specialist_if_category_has_been_mistaken(): void
    {
        $user = User::first();
        $specialist = User::factory()->has(Specialist::factory()->has(ServiceKind::factory()))
        ->create()->specialist;
        $response = $this->actingAs($user)->get(route('specialist.index', 
        [
            'searchTerm' => $specialist->name, 
            'categories' => [Category::first()->id], 
            'services' => [$specialist->serviceKinds()->first()->id]
        ]));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $page)  => $page
                ->component('User/FindSpecialist')
                ->has('paginatedSpecialists.data', 0
                )
        );
    }

    public function test_user_cant_find_specialist_if_service_kind_has_been_mistaken(): void
    {
        $user = User::first();
        $specialist = User::factory()->has(Specialist::factory()->has(Category::factory()))
        ->create()->specialist;
        $response = $this->actingAs($user)->get(route('specialist.index', 
        [
            'searchTerm' => $specialist->name, 
            'categories' => [$specialist->categories()->first()->id],  
            'services' => [ServiceKind::first()->id]
        ]));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $page)  => $page
                ->component('User/FindSpecialist')
                ->has('paginatedSpecialists.data', 0)
        );
    }


    public function test_user_counter_increment(): void
    {
        $user = User::first();
        $specialist = User::factory()->has(Specialist::factory()->has(ServiceKind::factory())->has(Category::factory()))
        ->create()->specialist;
        $preCounter=$specialist->found_counter;
        $response = $this->actingAs($user)->get(route('specialist.index', 
        [
            'searchTerm' => $specialist->name, 
            'categories' => [$specialist->categories()->first()->id], 
            'services' => [$specialist->serviceKinds()->first()->id]
        ]));

        $specialist->refresh();

        $this->assertEquals($preCounter+1,$specialist->found_counter);
    }

    //Guest test

    public function test_guest_can_see_find_specialists_page(): void
    {
        
        $response = $this->get(route('guest.specialist.index'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $page)  => $page
                ->component('Guest/FindSpecialist')
        );
    }

    public function test_guest_can_find_specialist(): void
    {
        
        $specialist = User::factory()->has(Specialist::factory()->has(ServiceKind::factory())->has(Category::factory()))
        ->create()->specialist;
        $response = $this->get(route('guest.specialist.index', 
        [
            'searchTerm' => $specialist->name, 
            'categories' => [$specialist->categories()->first()->id], 
            'services' => [$specialist->serviceKinds()->first()->id]
        ]));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $page)  => $page
                ->component('Guest/FindSpecialist')
                ->has('paginatedSpecialists.data.0', fn (Assert $page) => $page
                    ->where('id', $specialist->id)
                    ->etc()
                    )   
        );
    }

    public function test_guest_can_find_specialist_by_city_name(): void
    {
        
        $specialist = User::factory()->has(Specialist::factory()->has(ServiceCity::factory()))->create()->specialist;
        $response = $this->get(route('guest.specialist.index', 
        [
            'searchTerm' => $specialist->serviceCities()->first()->name, 
        ]));

        $response->assertStatus(200);
        //$responseSpecialistId = $response['props']['paginatedSpecialists']['data'][0]->id;
        $response->assertInertia(
            fn (Assert $page)  => $page
                ->component('Guest/FindSpecialist')
                ->has('paginatedSpecialists.data.0', fn (Assert $page) => $page
                    ->where('id', $specialist->id)
                    ->etc()
                    )   
        );
    }

    public function test_guest_cant_find_specialist_if_category_has_been_mistaken(): void
    {
        $user = User::first();
        $specialist = User::factory()->has(Specialist::factory()->has(ServiceKind::factory()))
        ->create()->specialist;
        $response = $this->actingAs($user)->get(route('guest.specialist.index', 
        [
            'searchTerm' => $specialist->name, 
            'categories' => [Category::first()->id], 
            'services' => [$specialist->serviceKinds()->first()->id]
        ]));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $page)  => $page
                ->component('Guest/FindSpecialist')
                ->has('paginatedSpecialists.data', 0
                )
        );
    }

    public function test_guest_cant_find_specialist_if_service_kind_has_been_mistaken(): void
    {
        
        $specialist = User::factory()->has(Specialist::factory()->has(Category::factory()))
        ->create()->specialist;
        $response = $this->get(route('guest.specialist.index', 
        [
            'searchTerm' => $specialist->name, 
            'categories' => [$specialist->categories()->first()->id],  
            'services' => [ServiceKind::first()->id]
        ]));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $page)  => $page
                ->component('Guest/FindSpecialist')
                ->has('paginatedSpecialists.data', 0)
        );
    }


    public function test_quest_found_counter_increment(): void
    {
        
        $specialist = User::factory()->has(Specialist::factory()->has(ServiceKind::factory())->has(Category::factory()))
        ->create()->specialist;
        $preCounter=$specialist->found_counter;
        $response = $this->get(route('guest.specialist.index', 
        [
            'searchTerm' => $specialist->name, 
            'categories' => [$specialist->categories()->first()->id], 
            'services' => [$specialist->serviceKinds()->first()->id]
        ]));

        $specialist->refresh();

        $this->assertEquals($preCounter+1,$specialist->found_counter);
    }
    
}
