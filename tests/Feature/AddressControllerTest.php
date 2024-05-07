<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Province;
use App\Models\MyRole;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        if(!Province::first()){
            $province = new Province();
            $province->name = "pomorskie";
            $province->save();
        }
        if(!MyRole::where("name","user")->exists())
        {
            MyRole::create(['name'=>'user']);
        }
        
    }
    
    public function test_user_can_create_address(): void
    {
        $province_id=Province::first()->id;
        $addressData=[
            'city'=>'Gdańsk',
            'province_id'=>$province_id,
            'line_1'=>'linia_1',
            'line_2'=>'linia_2',
            'code'=>'00-000',
        ];
        $user=User::factory()->create();
        $response= $this->actingAs($user)->post(route("address.store"),$addressData);
        $user->refresh();
        $address = $user->address;
        
        $response->assertRedirect();
        
        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals($addressData["city"], $address->city);
        $this->assertEquals($addressData["province_id"], $address->province_id);
        $this->assertEquals($addressData["line_1"], $address->line_1);
        $this->assertEquals($addressData["line_2"], $address->line_2);
        $this->assertEquals($addressData["code"], $address->code);
    }

    public function test_user_can_update_address(): void
    {
        $province_id=Province::first()->id;
        $addressData=[
            'city'=>'Gdańsk',
            'province_id'=>$province_id,
            'line_1'=>'linia_1',
            'line_2'=>'linia_2',
            'code'=>'00-000',
        ];
        $updatedData=array_map(fn ($value)=>substr($value,0,2),$addressData);
        $updatedProvince=Province::make();
        $updatedProvince->name='test province';
        $updatedProvince->save();
        $updatedData['province_id']=$updatedProvince->id;
        $user=User::factory()->create();
        $address=$user->address()->create($addressData);
        $response= $this->actingAs($user)->put(route("address.update",$address->id),$updatedData);

        $user->refresh();
        $address->refresh();
        
        $response->assertRedirect('/profil');
        
        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals($updatedData["city"], $address->city);
        $this->assertEquals($updatedData["province_id"], $address->province_id);
        $this->assertEquals($updatedData["line_1"], $address->line_1);
        $this->assertEquals($updatedData["line_2"], $address->line_2);
        $this->assertEquals($updatedData["code"], $address->code);
    }

    public function test_specialist_can_update_address(): void
    {
        $province_id=Province::first()->id;
        $addressData=[
            'city'=>'Gdańsk',
            'province_id'=>$province_id,
            'line_1'=>'linia_1',
            'line_2'=>'linia_2',
            'code'=>'00-000',
        ];
        $updatedData=array_map(fn ($value)=>substr($value,0,2),$addressData);
        $updatedProvince=Province::make();
        $updatedProvince->name='test province';
        $updatedProvince->save();
        $updatedData['province_id']=$updatedProvince->id;
        $user=User::factory()->create();
        $specialist=Specialist::factory()->make();
        $user->specialist()->save($specialist);
        $specialist->refresh();
        $address=$specialist->addresses()->create($addressData);
        $response= $this->actingAs($user)->put(route("specialist.address.update",[$specialist->id,$address->id]),$updatedData);
        
        $user->refresh();
        $address->refresh();
        
        $response->assertRedirect(route("specialist.profile.edit",$specialist->id));
        
        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals($updatedData["city"], $address->city);
        $this->assertEquals($updatedData["province_id"], $address->province_id);
        $this->assertEquals($updatedData["line_1"], $address->line_1);
        $this->assertEquals($updatedData["line_2"], $address->line_2);
        $this->assertEquals($updatedData["code"], $address->code);
    }
    public function test_user_cant_update_other_user_address(): void
    {
        $province_id=Province::first()->id;
        $addressData=[
            'city'=>'Gdańsk',
            'province_id'=>$province_id,
            'line_1'=>'linia_1',
            'line_2'=>'linia_2',
            'code'=>'00-000',
        ];
        $updatedData=array_map(fn ($value)=>substr($value,0,2),$addressData);
        $user=User::factory()->create();
        $address=User::factory()->create()->address()->create($addressData);
        $response= $this->actingAs($user)->put(route("address.update",$address->id),$updatedData);
        
        $response->assertUnauthorized();
    }

    public function test_specialist_cant_update_other_user_address(): void
    {
        $province_id=Province::first()->id;
        $addressData=[
            'city'=>'Gdańsk',
            'province_id'=>$province_id,
            'line_1'=>'linia_1',
            'line_2'=>'linia_2',
            'code'=>'00-000',
        ];
        $updatedData=array_map(fn ($value)=>substr($value,0,2),$addressData);
        $user=User::factory()->has(Specialist::factory())->create();
        $address=User::factory()->has(Specialist::factory())->create()->specialist->addresses()->create($addressData);
        $response= $this->actingAs($user)->put(route("specialist.address.update",[$user->specialist->id,$address->id]),$updatedData);
        
        $response->assertUnauthorized();
    }
    public function test_user_can_delete_address(): void
        {        
            $province_id=Province::first()->id;
            $addressData=[
                'city'=>'Gdańsk',
                'province_id'=>$province_id,
                'line_1'=>'linia_1',
                'line_2'=>'linia_2',
                'code'=>'00-000',
            ];
            $user=User::factory()->create();
            $address=$user->address()->create($addressData);
            $response= $this->actingAs($user)->delete(route("address.remove",$address->id));
            
            $response->assertRedirect();
            $this->assertModelMissing($address);
    }
    public function test_user_cant_delete_other_user_address(): void
    {        
        $province_id=Province::first()->id;
        $addressData=[
            'city'=>'Gdańsk',
            'province_id'=>$province_id,
            'line_1'=>'linia_1',
            'line_2'=>'linia_2',
            'code'=>'00-000',
        ];
        $user=User::factory()->create();
        $address=User::factory()->create()->address()->create($addressData);
        $response= $this->actingAs($user)->delete(route("address.remove",$address->id));
        
        
        $response->assertUnauthorized();
        $this->assertModelExists($address);
    }

    public function test_specialist_can_create_address(): void
    {
        $province_id=Province::first()->id;
        $addressData=[
            'city'=>'Gdańsk',
            'province_id'=>$province_id,
            'line_1'=>'linia_1',
            'line_2'=>'linia_2',
            'code'=>'00-000',
        ];
        $user=User::factory()->has(Specialist::factory())->create();
        $specialist=$user->specialist;
        $response= $this->actingAs($user)->post(route("specialist.address.store",$specialist->id),$addressData);

        
        $address=$specialist->addresses->first();

        $response->assertRedirect();

        $this->assertModelExists($address);
        foreach($addressData as $key=>$value)
        {
            $this->assertEquals($value, $address->$key);
        }
    }
}
