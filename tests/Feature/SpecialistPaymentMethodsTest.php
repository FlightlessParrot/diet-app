<?php

namespace Tests\Feature;

use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\MyRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Orchid\Platform\Models\Role;
use Tests\TestCase;

class SpecialistPaymentMethodsTest extends TestCase
{
    use RefreshDatabase;
    public function test_specialist_can_manage_payments_methods(): void
    {
        $this->seed(MyRolesSeeder::class);
        $specialist = User::factory()->has(Specialist::factory())->create()->specialist;
        $response = $this->actingAs($specialist->user)->put(route('specialist.payments',['paymentMethods'=>['karta','gotówka']]));
       
        $response->assertRedirect();
      
        $specialist->refresh();
        $payments = $specialist->paymentMethods()->get();
        $this->assertNotNull($payments);
        $this->assertCount(2,$payments);
    }
}
