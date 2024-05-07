<?php

namespace Tests\Feature;

use App\Models\Province;
use App\Models\MyRole;
use App\Models\ServiceKind;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceCityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_specialist_can_detach_service_city(): void
    {

        $this->seed();
        $user = User::where('my_role_id',MyRole::where('name','specialist')->first()->id)->firstOrFail();
        $specialist = $user->specialist;
        $specialist->serviceCities()->detach();
        $specialist->serviceKinds()->attach(ServiceKind::where('name','mobile')->first()->id);
        $serviceCity=$specialist->serviceCities()->create(['name'=>'Warsaw','province_id'=>Province::first()->id]);
        
        $response = $this->actingAs($user)->from(route('specialist.profile.edit',$specialist->id))
        ->delete(route('specialist.serviceCity.delete',$serviceCity));
   
        $response->assertRedirectToRoute('specialist.profile.edit',$specialist->id);
        $this->assertModelExists($serviceCity);
        $this->assertNull($specialist->serviceCities()->find($serviceCity->id));
        $this->assertNull($specialist->serviceKinds()->where('name','mobile')->first());
    }
}
