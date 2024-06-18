<?php

namespace Tests\Feature;

use App\Models\Province;
use App\Models\ServiceCity;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_specialist_can_see_form(): void
    {
        $this->seed(TestSeeder::class);
        $user = User::has("specialist")->first();
        $response = $this->actingAs($user)->get(route('service.form'));

        $response->assertStatus(200);
    }

    public function test_specialist_can_store_services(): void
    {
        $this->seed(TestSeeder::class);
        $data = [
            'serviceCities'=>[
                [
                    'name'=>'Warsaw',
                    'province_id' => Province::first()->id
                ],
                [
                    'name'=>'Gdansk',
                    'province_id' => Province::first()->id
                ]
                ],
            'online'=>[true],
            'stationary' =>[false]
            ];
        
        $user = User::has('specialist')->first();
        $numberOfCities=count($user->specialist->serviceCities()->get());
        $numberOfServiceKinds=count($user->specialist->serviceKinds()->get());
        $response = $this->actingAs($user)->post(route('store.services', $user->specialist->id), $data);
      
        $response->assertRedirectToRoute('category.attach');
        $this->assertNotEmpty(ServiceCity::where('name', 'Warsaw')->first());
        $this->assertNotEmpty(ServiceCity::where('name', 'Gdansk')->first());
        $this->assertCount($numberOfCities+2,$user->specialist->serviceCities()->get());
        $this->assertCount($numberOfServiceKinds+2,$user->specialist->serviceKinds()->get()); 
    }

    public function test_specialist_cant_send_empty_store_request(): void
    {
        $this->seed(TestSeeder::class);
        
        $user = User::has('specialist')->first();
        $numberOfCities=count($user->specialist->serviceCities()->get());
        $numberOfServiceKinds=count($user->specialist->serviceKinds()->get());
        $response = $this->actingAs($user)->from(route('service.form'))->post(route('store.services', $user->specialist->id));
      
        $response->assertRedirectToRoute('service.form');
        $this->assertEmpty(ServiceCity::where('name', 'Warsaw')->first());
        $this->assertEmpty(ServiceCity::where('name', 'Gdansk')->first());
        $this->assertCount($numberOfCities,$user->specialist->serviceCities()->get());
        $this->assertCount($numberOfServiceKinds,$user->specialist->serviceKinds()->get()); 
    }
    
}
