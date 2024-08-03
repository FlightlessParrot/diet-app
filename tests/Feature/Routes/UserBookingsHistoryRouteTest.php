<?php

namespace Tests\Feature\Routes;

use App\Models\Booking;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class UserBookingsHistoryRouteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_see_bookings_history(): void
    {
        $this->seed(TestSeeder::class);
        $user = User::factory()->create();
        
        do{
            $booking=Booking::whereNull('user_id')->firstOrFail();
            $booking->user()->associate($user);
            $booking->save();

        }while(count($user->bookings()->get())!==3);
        $user->refresh();
        $response = $this->actingAs($user)
        ->get(route('user.bookings.index'))->assertInertia(fn (AssertableInertia $page) => $page
        ->component('User/YourBookings')
        ->has('bookings.data',3));

        $response->assertStatus(200);
    }
}
