<?php

namespace Tests\Feature;

use App\Events\BookingConfirmed;
use App\Events\BookingDeleted;
use App\Events\BookingSet;
use App\Models\Address;
use App\Models\Anonym;
use App\Models\Booking;
use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;
    public function test_start_date_must_be_earlier_than_end_date(): void
    {
        $this->seed(TestSeeder::class);
        $startDate=(floor(time()/86400))*86400+2*86400+00001;
        $endDate=$startDate-86400+2*60*30;
        $isoStartDate=date('c', $startDate);
        $isoEndDate=date('c', $endDate);
        $user =  User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        

        $response = $this->actingAs($user)->post(route('bookings.store',[$specialist->id]),['selectedDate'=>['start'=>$isoStartDate,'end'=>$isoEndDate],
        'days'=>[]]);
        
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
        $isoStartDate=date('c', $startDate);
        $isoEndDate=date('c', $endDate);
        $user =  User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        
        
        $response = $this->actingAs($user)->post(route('bookings.store',[$specialist->id]),
        ['days'=>array(),'selectedDate'=>['start'=>$isoStartDate,'end'=>$isoEndDate],]);
        
        $response->assertSessionHas(['message'=>[
            'text' => 'Pomiędzy początkową, a końcową godziną musi być przynajmniej 30 minut.',
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
        $isoStartDate=date('c', $startDate);
        $isoEndDate=date('c', $endDate);
        $user =  User::factory()->has(Specialist::factory()->has(Address::factory()))->create();
        $specialist = $user->specialist;
        $address = $specialist->addresses()->first();

        $response = $this->from('/example/url')->actingAs($user)->post(route('bookings.store',[$specialist->id]),
        ['selectedDate'=>['start'=>$isoStartDate,'end'=>$isoEndDate],'address'=>$address->id,'days'=>[]]);
        
        $response->assertRedirect('/example/url');
        $specialist->refresh();
        $bookings=$specialist->bookings()->get();
        $this->assertCount(4,$bookings);
        foreach($bookings as $booking)
        {
            $this->assertEquals($address->id, $booking->address->id);
        }
    }

    public function test_specialist_can_store_booking_by_day_of_week(): void
    {
        $this->seed(TestSeeder::class);
        $startDate=(floor(time()/86400))*86400+13*86400;
        $endDate=$startDate+86400*7+2*60*35;
        $isoStartDate=date('c', $startDate);
        $isoEndDate=date('c', $endDate);
        $user =  User::factory()->has(Specialist::factory()->has(Address::factory()))->create();
        
        $specialist = $user->specialist;
        $address = $specialist->addresses()->first();

        $response = $this->from('/example/url')->actingAs($user)->post(route('bookings.store',[$specialist->id]),
        ['selectedDate'=>['start'=>$isoStartDate,'end'=>$isoEndDate],'address'=>$address->id,'days'=>[(int)date('N',$startDate)]]);
        
        $response->assertRedirect('/example/url');
        $specialist->refresh();
        $bookings=$specialist->bookings()->get();
        $this->assertCount(4,$bookings);
        foreach($bookings as $booking)
        {
            $this->assertEquals($address->id, $booking->address->id);
        }
    }
    // public function test_specialist_cant_duplicate_booking(): void
    // {
    //     $this->seed(TestSeeder::class);
    //     $startDate=(floor(time()/86400))*86400+2*86400+00001;
    //     $endDate=$startDate+86400+2*60*30;
    //     $isoStartDate=date('c', $startDate);
    //     $isoEndDate=date('c', $endDate);
    //     $user =  User::factory()->has(Specialist::factory())->create();
    //     $specialist = $user->specialist;
    //     $specialist->bookings()->create(['start_date'=>date('c', $startDate+2*60*60),'end_date'=>date('c', $startDate+60*30+2*60*60)]);

    //     $response = $this->actingAs($user)->post(route('bookings.store',[$specialist->id]),['selectedDate'=>['start'=>$isoStartDate,'end'=>$isoEndDate]]);
        
    //     $response->assertRedirect();
    //     $specialist->refresh();
    //     $bookings=$specialist->bookings()->get();
    //     $this->assertCount(4,$bookings);
    // }

    public function test_specialist_can_delete_booking(): void
    {
        $this->seed(TestSeeder::class);
        Event::fake();
        $startDate=(floor(time()/86400))*86400+2*86400+00001;
        $user =  User::factory()->has(Specialist::factory())->create();
        $specialist = $user->specialist;
        $booking=$specialist->bookings()->create(['start_date'=>date('c', $startDate+2*60*60),'end_date'=>date('c', $startDate+60*30+2*60*60),'days'=>[]]);

        $response = $this->actingAs($user)->delete(route('bookings.destroy',[$specialist->id,$booking->id]));
        
        $response->assertRedirect();
        $this->assertModelMissing($booking);
        Event::assertDispatched(BookingDeleted::class);
    }

    public function test_user_can_book(): void
    {
        $this->seed(TestSeeder::class);
        Event::fake();
        $user =  User::factory()->has(Specialist::factory())->create();
 
        $booking=Booking::Where('status','created')->firstOrFail();


        $response = $this->actingAs($user)->patch(route('bookings.reserve',[$booking->id]));
        
        $booking->refresh();
        $response->assertRedirect();
        $this->assertSame($booking->status,'pending');
        $this->assertSame($user->id, $booking->user->id);
        Event::assertDispatched(BookingSet::class);
    }
    public function test_guest_can_book(): void
    {
        $this->seed(TestSeeder::class);
        Event::fake();
     
 
        $booking=Booking::Where('status','created')->firstOrFail();


        $response = $this->patch(route('guest.bookings.reserve',[$booking->id]),['full_name'=>'Thomas','email'=>'thomas@email.com','number'=>'123123123']);
        
        $booking->refresh();
        $anonym = $booking->anonym()->firstOrFail();
        $response->assertRedirect();
        $this->assertSame($booking->status,'pending');
        $this->assertNotNull($anonym);
        $this->assertSame('Thomas',$anonym->full_name);
        $this->assertSame('thomas@email.com',$anonym->email);
        $this->assertSame('123123123',$anonym->phone->number);
        Event::assertDispatched(BookingSet::class);
    }
    public function test_specialist_can_change_status(): void
    {
        $this->seed(TestSeeder::class);
        Event::fake();
        $user =  User::factory()->has(Specialist::factory()->has(Booking::factory(['status'=>'pending'])))->create();

        $specialist = $user->specialist;
        $booking=$specialist->bookings()->firstOrFail();
        $booking->user()->associate(User::factory()->create());
        $booking->save();
        
        $response = $this->actingAs($user)->patch(route('bookings.status',[$booking->id]),['status'=>'confirmed']);
        $booking->refresh();
        $response->assertRedirect();
        $this->assertSame($booking->status,'confirmed');
        Event::assertDispatched(BookingConfirmed::class);
    }
}
