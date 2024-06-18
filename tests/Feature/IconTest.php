<?php

namespace Tests\Feature;

use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class IconTest extends TestCase
{

    use RefreshDatabase;
    

    public function test_user_can_upload_icon() : void
    {
        
        $this->seed(TestSeeder::class);
        Storage::fake();
        $file=UploadedFile::fake()->image('avatar.jpg', 250, 250)->size(1000);
        $user = User::factory()->has(Specialist::factory())->create();
        $response = $this->actingAs($user)->post(route('icon.store',[$user->specialist->id]), [
            'icon' => $file,
        ]);
        
        $response->assertRedirect();

        Storage::assertExists('public/specialist/icons/'.$file->hashName());
    }

    public function test_user_can_delete_icon() : void
    {
        $this->seed(TestSeeder::class);
         Storage::fake();
        $file=UploadedFile::fake()->image('avatar.jpg', 250, 250)->size(1000);
        $user = User::factory()->has(Specialist::factory())->create();
        
        $path = Storage::putFile('public/specialist/icons', $file);  
        $url = Storage::url($path);
        $icon=$user->specialist->icon()->create(['path' => $path, 'url' => $url]);
        $response = $this->actingAs($user)->delete(route('icon.delete',[$icon->id]));
        
        $response->assertRedirect();

        $this->assertModelMissing($icon);
        Storage::assertMissing('public/specialist/icons/'.$file->hashName());
    }

    public function test_user_cant_upload_too_wide_icon() : void
    {
        $this->seed(TestSeeder::class);
        Storage::fake();
        $file=UploadedFile::fake()->image('avatar.jpg', 300, 250)->size(1000);
        $user = User::factory()->has(Specialist::factory())->create();
        $response = $this->actingAs($user)->post(route('icon.store',[$user->specialist->id]), [
            'icon' => $file,
        ]);
        
        $response->assertRedirect()->assertSessionHasErrors(['icon']);

        Storage::assertMissing('public/specialist/icons/'.$file->hashName());
        $this->assertNull($user->specialist->icon);
    }

    public function test_user_cant_upload_too_high_icon() : void
    {
        $this->seed(TestSeeder::class);
        Storage::fake();
        $file=UploadedFile::fake()->image('avatar.jpg', 250, 300)->size(1000);
        $user = User::factory()->has(Specialist::factory())->create();
        $response = $this->actingAs($user)->post(route('icon.store',[$user->specialist->id]), [
            'icon' => $file,
        ]);
        
        $response->assertRedirect()->assertSessionHasErrors(['icon']);

        Storage::assertMissing('public/specialist/icons/'.$file->hashName());
        $this->assertNull($user->specialist->icon);
    }

    public function test_user_cant_upload_too_heavy_icon() : void
    {
        $this->seed(TestSeeder::class);
        Storage::fake();
        $file=UploadedFile::fake()->image('avatar.jpg', 250, 250)->size(200000);
        $user = User::factory()->has(Specialist::factory())->create();
        $response = $this->actingAs($user)->post(route('icon.store',[$user->specialist->id]), [
            'icon' => $file,
        ]);
        
        $response->assertRedirect()->assertSessionHasErrors(['icon']);

        Storage::assertMissing('public/specialist/icons/'.$file->hashName());
        $this->assertNull($user->specialist->icon);
    }
}
