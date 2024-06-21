<?php

namespace Tests\Feature;

use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;
    public function test_start_date_must_be_earlier_than_end_date(): void
    {
        $this->seed(TestSeeder::class);
        $startDate=(floor(time()/86400))*86400+2*86400+00001;
        $endDate=$startDate-86400+2*60*30;
        $isoStartDate=date('Y-m-d\TH:i:s.Z\Z', $startDate);
        $isoEndDate=date('Y-m-d\TH:i:s.Z\Z', $endDate);
        $user =  User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        

        $response = $this->actingAs($user)->post(route('bookings.store',[$specialist->id]),['selectedDate'=>['start'=>$isoStartDate,'end'=>$isoEndDate]]);
        
        $response->assertSessionHasErrors();
        $specialist->refresh();
        $bookings=$specialist->bookings()->get();
        $this->assertCount(0,$bookings);
    }
    public function test_start_time_must_be_earlier_than_end_time(): void
    {
        $this->seed(TestSeeder::class);
        $startDate=(floor(time()/86400))*86400+2*86400+2*60*30;
        $endDate=(floor(time()/86400))*86400+3*86400+1;
        $isoStartDate=date('Y-m-d\TH:i:s.Z\Z', $startDate);
        $isoEndDate=date('Y-m-d\TH:i:s.Z\Z', $endDate);
        $user =  User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        

        $response = $this->actingAs($user)->post(route('bookings.store',[$specialist->id]),['selectedDate'=>['start'=>$isoStartDate,'end'=>$isoEndDate]]);
        
        $response->assertSessionHas(['message'=>[
            'text' => 'Pomięczy początkową, a końcową godziną musi być przynajmniej 30 minut.',
            'status' => 'error'
        ]]);
        $bookings=$specialist->bookings()->get();
        $this->assertCount(0,$bookings);
    }
    public function test_specialist_can_store_booking(): void
    {
        $this->seed(TestSeeder::class);
        $startDate=(floor(time()/86400))*86400+2*86400+00001;
        $endDate=$startDate+86400+2*60*30;
        $isoStartDate=date('Y-m-d\TH:i:s.Z\Z', $startDate);
        $isoEndDate=date('Y-m-d\TH:i:s.Z\Z', $endDate);
        $user =  User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        

        $response = $this->actingAs($user)->post(route('bookings.store',[$specialist->id]),['selectedDate'=>['start'=>$isoStartDate,'end'=>$isoEndDate]]);
        
        
        $response->assertRedirect();
        $specialist->refresh();
        $bookings=$specialist->bookings()->get();
        $this->assertCount(4,$bookings);
    }
    public function test_specialist_cant_duplicate_booking(): void
    {
        $this->seed(TestSeeder::class);
        $startDate=(floor(time()/86400))*86400+2*86400+00001;
        $endDate=$startDate+86400+2*60*30;
        $isoStartDate=date('Y-m-d\TH:i:s.Z\Z', $startDate);
        $isoEndDate=date('Y-m-d\TH:i:s.Z\Z', $endDate);
        $user =  User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        $specialist->bookings()->create(['start_date'=>date('Y-m-d H:i:s', $startDate+2*60*60),'end_date'=>date('Y-m-d H:i:s', $startDate+60*30+2*60*60)]);

        $response = $this->actingAs($user)->post(route('bookings.store',[$specialist->id]),['selectedDate'=>['start'=>$isoStartDate,'end'=>$isoEndDate]]);
        
        $response->assertRedirect();
        $specialist->refresh();
        $bookings=$specialist->bookings()->get();
        $this->assertCount(4,$bookings);
    }

    public function test_specialist_can_delete_booking(): void
    {
        $this->seed(TestSeeder::class);
        $startDate=(floor(time()/86400))*86400+2*86400+00001;
        $user =  User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        $booking=$specialist->bookings()->create(['start_date'=>date('Y-m-d H:i:s', $startDate+2*60*60),'end_date'=>date('Y-m-d H:i:s', $startDate+60*30+2*60*60)]);

        $response = $this->actingAs($user)->delete(route('bookings.destroy',[$specialist->id,$booking->id]));
        
        $response->assertRedirect();
        $this->assertModelMissing($booking);
    }
}
