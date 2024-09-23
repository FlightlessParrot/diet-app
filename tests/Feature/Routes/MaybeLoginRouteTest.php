<?php

namespace Tests\Feature\Routes;

use App\Models\MyRole;
use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\MyRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class MaybeLoginRouteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->seed([MyRolesSeeder::class]);

        $specialist=User::factory()->has(Specialist::factory())->create()->specialist;
        $response = $this->get(route('maybe.login',[$specialist->id]))->assertInertia(fn(AssertableInertia $page)=>$page->component('Guest/MaybeLogin')->has('specialist'));

        $response->assertStatus(200);
    }
}
