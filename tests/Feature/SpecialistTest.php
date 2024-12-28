<?php

namespace Tests\Feature;

use App\Enums\Specialization;
use App\Enums\Title;
use App\Models\MyRole;
use App\Models\Specialist;
use App\Models\Target;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class SpecialistTest extends TestCase
{
    
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_get_specialist_view(): void
    {
        $this->seed(TestSeeder::class);
        $user = User::doesntHave("specialist")->first();
        $response = $this->actingAs($user)->get(route("specialist.create"));
        
        $response->assertStatus(200); 
    }

    public function test_specialist_cannot_see_specialist_view(): void
    {
        $this->seed(TestSeeder::class);
        $user = User::has("specialist")->first();
        $response = $this->actingAs($user)->get(route("specialist.create"));

        $response->assertRedirect('/profil')->assertSessionHasErrors('text');
    }

    public function test_user_can_create_specialist(): void
    {
        $number='123123123';
        $this->seed(TestSeeder::class);
        $user = User::doesntHave("specialist")->first();
        $targets=Target::all();
        $response = $this->actingAs($user)->post(route("specialist.store"),[
            'title'=>Title::MGR_INZ->value,
            'specializations'=>[Specialization::DK->value],
            'name' => fake()->name(),
            'surname' => fake()->lastName(),
            'number' => $number,
            'targets'=>[$targets[0]->id,$targets[1]->id]
        ]);
        $user->refresh();
        $response->assertRedirect(route('course.create'));

        $specialist=$user->specialist;
        $specialistTargets = $specialist->targets()->get();
        $this->assertModelExists($specialist);
        $this->assertNotNull($specialist->phone);
        $this->assertSame($number,$specialist->phone->number);
        $this->assertCount(2,$specialistTargets);
        $this->assertNotNull($specialistTargets->find($targets[0]->id));
        $this->assertNotNull($specialistTargets->find($targets[1]->id));
        $this->assertSame($specialist->specializations()->first()->name,Specialization::DK->value);
        $this->assertSame($specialist->title,Title::MGR_INZ->value);
        $this->assertEquals(MyRole::where('name','specialist')->first(), $user->myRole);
    }

    public function test_specialist_cant_create_specialist(): void
    {
        $this->seed(TestSeeder::class);
        $user = User::has("specialist")->first();
        $response = $this->actingAs($user)->post(route("specialist.store"),[
            'title'=>Title::MGR_INZ->value,
            'specializations'=>[Specialization::DK->value],
            'name' => fake()->name(),
            'surname' => fake()->lastName(),
            'number' => '12342232'
        ]);
        $user->refresh();
        $response->assertRedirect(route('specialist.create'));

        
    }
    public function test_specialist_can_remove_specialist(): void
    {
        $this->seed(TestSeeder::class);
        $user = User::factory()->has(Specialist::factory())->create(['password'=>Hash::make('password')]);
        $specialist=$user->specialist;
        $response = $this->actingAs($user)->delete(route("specialist.remove",$specialist->id),[
            'password'=>'password'
        ]);

        $user->refresh();
        $response->assertRedirect(route('dashboard'));
        $this->assertModelMissing($specialist);
        $this->assertEquals(MyRole::where('name','user')->first()->id, $user->myRole->id);
    }

    public function test_specialist_can_update_data()
    {
        $this->seed(TestSeeder::class);
        $user=User::factory()->create();
        $targets=Target::all();
        $specialist=$user->specialist()->save(Specialist::make([
            'title'=>Title::MGR_INZ->value,
            'specializations'=>[Specialization::DK->value],
            'name' => 'John',
            'surname' => 'Smith',
            
        ]));
        $title=Title::DR_HAB;
        $specialization = Specialization::DK;
        $response = $this->actingAs($user)->from(route('specialist.profile.edit',$specialist->id))->put(route('specialist.profile.update',$specialist->id),[
            'title'=>$title->value,
            'specializations'=>[$specialization->value],
            'name' => 'Johannes',
            'surname' => 'Smith',
            'targets'=>[$targets[0]->id,$targets[1]->id]
        ]);
        $specialist=$specialist->refresh();
        $specialistTargets = $specialist->targets()->get();

        $response->assertRedirectToRoute('specialist.profile.edit',$specialist->id);
        $this->assertSame($specialist->title,$title->value);
        $this->assertSame($specialist->specializations()->first()->name,$specialization->value);
        $this->assertSame($specialist->name,'Johannes');
        $this->assertSame($specialist->surname,'Smith');

        $this->assertCount(2,$specialistTargets);
        $this->assertNotNull($specialistTargets->find($targets[0]->id));
        $this->assertNotNull($specialistTargets->find($targets[1]->id));
    }

    public function test_avatars_can_be_uploaded(): void
    {
        Storage::fake();
        $this->seed(TestSeeder::class);
        $file = UploadedFile::fake()->image('avatar.jpg');
        $user = User::has("specialist")->first();

        $response = $this->actingAs($user)->post(route('avatar.store', $user->specialist->id), [
            'avatar' => $file,
        ]);
        $response->assertRedirect();
        $this->assertNotEmpty($user->specialist->attachment()->first());
        $user->specialist->attachment()->first()->delete();
    }
}
