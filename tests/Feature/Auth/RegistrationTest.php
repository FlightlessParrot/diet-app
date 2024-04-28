<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        if(!Role::where("name","user")->exists())
        {
            Role::create(['name'=>'user']);
        }
        
    }
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'surname' => 'Test surname',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
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
        ]);
        $role=Role::where('name','user')->firstOrFail();
        $user=User::where('email','test@example.com')->firstOrFail();
        $this->assertSame($role->id,$user->role_id);

    }
}
