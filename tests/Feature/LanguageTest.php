<?php

namespace Tests\Feature;

use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use League\CommonMark\Util\SpecReader;
use Tests\TestCase;

class LanguageTest extends TestCase
{
   use RefreshDatabase;

   public function setUp(): void
   {
    parent::setUp();
    $this->seed([TestSeeder::class]);
   }
    public function test_specialist_can_store_language(): void
    {
        $user=User::factory()->has(Specialist::factory())->create();
        $data=[
            'name'=>'Jamnikowy'
        ];
        $route=route('specialist.profile.edit',[$user->specialist->id]);
        $response = $this->from($route)->actingAs($user)->post(route('language.store'),$data);
        $language=$user->specialist->languages()->first();
        $response->assertRedirect($route)->assertSessionHas('message',['text' => 'Dodano język.', 'status' => 'success']);
        $this->assertNotNull($language);
        $this->assertSame($language->name,strtolower($data['name']));
    }

    public function test_specialist_can_update_language() : void
    {   
        $specialist=Specialist::has('languages')->firstOrFail();
        $user=$specialist->user;
        $data=[
            'name'=>'Jamnikowy'
        ];
        $route=route('specialist.profile.edit',[$specialist->id]);
        $language=$user->specialist->languages()->firstOrFail();

        $response = $this->from($route)->actingAs($user)->put(route('language.update',[$language->id]),$data);
        
        $language->refresh();
        $response->assertRedirect($route)->assertSessionHas('message',['text' => 'Edytowano język.', 'status' => 'success']);
        $this->assertNotNull($language);
        $this->assertSame($language->name,strtolower($data['name']));
    }

    public function test_specialist_can_delete_language() : void
    {   
        $specialist=Specialist::has('languages')->firstOrFail();
        $user=$specialist->user;
        $data=[
            'name'=>'Jamnikowy'
        ];
        $route=route('specialist.profile.edit',[$specialist->id]);
        $language=$user->specialist->languages()->firstOrFail();

        $response = $this->from($route)->actingAs($user)->delete(route('language.update',[$language->id]),$data);
        
        $response->assertRedirect($route)->assertSessionHas('message',['text' => 'Usunięto język.', 'status' => 'success']);
        $this->assertModelMissing($language);
    }
}
