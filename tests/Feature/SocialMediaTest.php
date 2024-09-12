<?php

namespace Tests\Feature;


use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\MyRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SocialMediaTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed([MyRolesSeeder::class]);
    }
    public function test_user_can_store_social_media(): void
    {   $user = User::factory()->has(Specialist::factory())->create();
        $data = [
            'url' => 'http://example.com',
            'type' => 'facebook'
        ];


        $response = $this->from('http://myapp.com')->actingAs($user)->post(route('socialMedia.store'), $data);
       
        $response->assertRedirect('http://myapp.com')->assertSessionHas('message', ['text' => 'Utworzono link.', 'status' => 'success']);

        $socialMedia = $user->specialist->socialMedias()->first();
        $this->assertNotNull($socialMedia);
        $this->assertEquals($data['url'], $socialMedia['url']);
        $this->assertEquals($data['type'], $socialMedia['type']);
    }
    public function test_user_cannot_have_two_same_type_social_media(): void
    {

        
        $user = User::factory()->has(Specialist::factory())->create();
        $socialMedia = $user->specialist->socialMedias()->create(['url' => 'http://sth.org', 'type' => 'facebook']);
        $data = [
            'url' => 'http://example.com',
            'type' => 'facebook'
        ];
        $response = $this->from('http://myapp.com')->actingAs($user)->post(route('socialMedia.store'), $data);

        $response->assertRedirect('http://myapp.com')->assertSessionHas('message', [
            'text' => 'Link do profilu tego typu juz istnieje.',
            'status' => 'error'
        ]);

        $socialMedias = $user->specialist->socialMedias()->get();
        $this->assertCount(1, $socialMedias);
    }

    public function test_user_can_update_social_media(): void
    {
        $user = User::factory()->has(Specialist::factory())->create();
        $socialMedia = $user->specialist->socialMedias()->create(['url' => 'http://sth.org', 'type' => 'instagram']);
        $data = [
            'url' => 'http://example.com',
            'type' => 'facebook'
        ];
        $response = $this->from('http://myapp.com')->actingAs($user)
            ->put(route(name: 'socialMedia.update', parameters: [$socialMedia->id]), data: $data);
        $socialMedia->refresh();
        $response->assertRedirect('http://myapp.com')->assertSessionHas('message', ['text' => 'Zmieniono link.', 'status' => 'success']);
        $this->assertEquals($data['url'], $socialMedia['url']);
        $this->assertEquals($data['type'], $socialMedia['type']);
    }

    public function test_user_can_not_update_other_user_social_media(): void
    {
        $user = User::factory()->has(Specialist::factory())->create();
        $socialMedia = $user->specialist->socialMedias()->create(['url' => 'http://sth.org', 'type' => 'instagram']);
        $data = [
            'url' => 'http://example.com',
            'type' => 'facebook'
        ];
        $secondUser = User::factory()->has(Specialist::factory())->create();


        $response = $this->from('http://myapp.com')->actingAs($secondUser)
            ->put(route(name: 'socialMedia.update', parameters: [$socialMedia->id]), data: $data);


        $socialMedia->refresh();
        $response->assertRedirect('http://myapp.com')->assertSessionHas('message', ['text' => 'Wystapil blad.', 'status' => 'error']);
        $this->assertNotEquals($data['url'], $socialMedia['url']);
        $this->assertNotEquals($data['type'], $socialMedia['type']);
    }

    public function test_user_can_delete_social_media()
    {
        $user = User::factory()->has(Specialist::factory())->create();
        $socialMedia = $user->specialist->socialMedias()->create(['url' => 'http://sth.org', 'type' => 'instagram']);
        $response = $this->from('http://myapp.com')->actingAs($user)
            ->delete(route(name: 'socialMedia.destroy', parameters: [$socialMedia->id]));

        $response->assertRedirect('http://myapp.com')->assertSessionHas('message', ['text' => 'Zmieniono link.', 'status' => 'success']);
        $this->assertModelMissing($socialMedia);
    }

    public function test_user_cannot_delete_others_social_media()
    {
        $user = User::factory()->has(Specialist::factory())->create();
        $socialMedia = $user->specialist->socialMedias()->create(['url' => 'http://sth.org', 'type' => 'instagram']);
        $secondUser = User::factory()->has(Specialist::factory())->create();

        $response = $this->from('http://myapp.com')->actingAs($secondUser)
            ->delete(route(name: 'socialMedia.destroy', parameters: [$socialMedia->id]));

        $response->assertRedirect('http://myapp.com')->assertSessionHas('message', ['text' => 'Wystapil blad.', 'status' => 'error']);
        $this->assertModelExists($socialMedia);
    }
}
