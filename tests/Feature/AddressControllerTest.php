<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    
    protected function setUp(): void
    {
        parent::setUp();
        if(!Role::where("name","user")->exists())
        {
            Role::create(['name'=>'user']);
        }
        
    }
    
    public function test_user_can_create_address(): void
    {
        $addressData=[
            'city'=>'Gdańsk',
            'province'=>'pomorskie',
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
        $this->assertEquals($addressData["province"], $address->province);
        $this->assertEquals($addressData["line_1"], $address->line_1);
        $this->assertEquals($addressData["line_2"], $address->line_2);
        $this->assertEquals($addressData["code"], $address->code);
    }

    public function test_user_can_update_address(): void
    {
        $addressData=[
            'city'=>'Gdańsk',
            'province'=>'pomorskie',
            'line_1'=>'linia_1',
            'line_2'=>'linia_2',
            'code'=>'00-000',
        ];
        $updatedData=array_map(fn ($value)=>substr($value,0,2),$addressData);
        $user=User::factory()->create();
        $address=$user->address()->create($addressData);
        $response= $this->actingAs($user)->put(route("address.update",$address->id),$updatedData);

        $user->refresh();
        $address->refresh();
        
        $response->assertRedirect();
        
        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals($updatedData["city"], $address->city);
        $this->assertEquals($updatedData["province"], $address->province);
        $this->assertEquals($updatedData["line_1"], $address->line_1);
        $this->assertEquals($updatedData["line_2"], $address->line_2);
        $this->assertEquals($updatedData["code"], $address->code);
    }

    public function test_user_cant_update_other_user_address(): void
    {
        $addressData=[
            'city'=>'Gdańsk',
            'province'=>'pomorskie',
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

    public function test_user_can_delete_address(): void
        {        
            $addressData=[
                'city'=>'Gdańsk',
                'province'=>'pomorskie',
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
        $addressData=[
            'city'=>'Gdańsk',
            'province'=>'pomorskie',
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
}
