<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpecialistTest extends TestCase
{
    
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_get_specialist_view(): void
    {
        $this->seed();
        $user = User::doesntHave("specialist")->first();
        $response = $this->actingAs($user)->get(route("specialist.create"));
        
        $response->assertStatus(200); 
    }

    public function test_specialist_cannot_see_specialist_view(): void
    {
        $this->seed();
        $user = User::has("specialist")->first();
        $response = $this->actingAs($user)->get(route("specialist.create"));

        $response->assertRedirect('/profil')->assertSessionHasErrors('text');
    }

    public function test_user_can_create_specialist(): void
    {
        $this->seed();
        $user = User::doesntHave("specialist")->first();
        $response = $this->actingAs($user)->post(route("specialist.store"),[
            'title'=>'dietician',
            'name' => fake()->name(),
            'surname' => fake()->lastName(),
        ]);
        $user->refresh();
        $response->assertRedirect(route('specialist.address.create'));
        $this->assertModelExists($user->specialist);
        $this->assertEquals(Role::where('name','specialist')->first(), $user->role);
    }

    public function test_specialist_cant_create_specialist(): void
    {
        $this->seed();
        $user = User::has("specialist")->first();
        $response = $this->actingAs($user)->post(route("specialist.store"),[
            'title'=>'dietician',
            'name' => fake()->name(),
            'surname' => fake()->lastName(),
        ]);
        $user->refresh();
        $response->assertRedirect(route('specialist.create'));

        
    }
    public function test_specialist_can_remove_specialist(): void
    {
        $this->seed();
        $user = User::has("specialist")->first();
        $specialist=$user->specialist;
        $response = $this->actingAs($user)->delete(route("specialist.remove",$specialist->id),[
            'title'=>'dietician',
            'name' => fake()->name(),
            'surname' => fake()->lastName(),
        ]);

        $user->refresh();
        $response->assertRedirect(route('dashboard'));
        $this->assertModelMissing($specialist);
        $this->assertEquals(Role::where('name','user')->first()->id, $user->role->id);
    }
}
