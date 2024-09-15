<?php

namespace Tests\Feature\Auth;

use App\Models\MyRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        if(!MyRole::where("name","user")->exists())
        {
            MyRole::create(['name'=>'user']);
        }
        
    }
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $number='123123123';
        $response = $this->post('/register', [
            'name' => 'Test User',
            'surname' => 'Test surname',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'number'=>$number,
            'newsletter'=>false
        ]);

        $user = User::first();
        
        $this->assertAuthenticated();
        
        $this->assertNotNull($user->phone);
        $this->assertSame($number,$user->phone->number);
        $this->assertSame(0,$user->newsletter);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_registrated_user_has_role_user(): void
    {
        
        $response = $this->post('/register', [
            'name' => 'Test User',
            'surname' => 'Test surname',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'number'=>'123123123',
            'newsletter'=>false
        ]);
        $role=MyRole::where('name','user')->firstOrFail();
        $user=User::where('email','test@example.com')->firstOrFail();
        $this->assertSame($role->id,$user->my_role_id);

    }
}
