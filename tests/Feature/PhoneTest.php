<?php

namespace Tests\Feature;

use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhoneTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
    Parent::setUp();
    $this->seed(TestSeeder::class);
    }
    public function test_user_can_update_phone_number(): void
    {  
        $number = '345345345';
        $user = User::has('phone')->first();
        $response = $this->actingAs($user)->put(route('phone.update',[$user->phone->id]),['number'=>$number]);
        $user->refresh();
        $this->assertEquals($user->phone->number,$number);
    }

    public function test_user_cannot_update_another_user_phone_number(): void
    {
        $number = '345345345';
        $user = User::has('phone')->first();
        $anotherUser=User::has('phone')->whereNot('id',$user->id)->first();
        $response = $this->actingAs($user)->put(route('phone.update',[$anotherUser->phone->id]),['number'=>$number]);
        $anotherUser->refresh();
        $this->assertNotEquals($anotherUser->phone->number,$number);
    }

    public function test_specialist_can_update_phone_number(): void
    {  
        $number = '345345345';
        $specialist = Specialist::has('phone')->first();
        $response = $this->actingAs($specialist->user)->put(route('phone.update',[$specialist->phone->id]),['number'=>$number]);
        $specialist->refresh();
        $this->assertEquals($specialist->phone->number,$number);
    }

    public function test_specialist_cannot_update_another_user_phone_number(): void
    {
        $number = '345345345';
        $specialist = Specialist::has('phone')->first();
        $anotherSpecialist=Specialist::has('phone')->whereNot('id',$specialist->id)->first();
        $response = $this->actingAs($specialist->user)->put(route('phone.update',[$anotherSpecialist->phone->id]),['number'=>$number]);
        $anotherSpecialist->refresh();
        $this->assertNotEquals($anotherSpecialist->phone->number,$number);
    }
}
