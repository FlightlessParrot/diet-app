<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\MyRolesSeeder;
use Database\Seeders\TestSeeder;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;
    public function test_specialist_can_store_course(): void
    {
        $this->seed([MyRolesSeeder::class]);
        $user=User::factory()->has(Specialist::factory())->create();
        $now = new DateTime();
        $tomorrow = new DateTime();
        $tomorrow->modify('+1 day');

        $data = [
            'name' => 'Test name',
            'selectedDate' =>[
                'start'=>$now->format('Y-m-d'),
                'end' =>$tomorrow->format('Y-m-d')
            ]
            ];

        $response = $this->from('/base/route')->actingAs($user)->post(route('course.store',[$user->specialist->id]),$data);
        

        $response->assertRedirect('/base/route')->assertSessionHas('message', ['text' => 'Dodano szkolenie.', 'status' => 'success']);
        $course=$user->specialist->courses()->first();
        $this->assertNotNull($course);
        $this->assertSame($data['name'],$course->name);
        $this->assertSame($now->format('Y-m-d'),$course->start_date->format('Y-m-d'));
        $this->assertSame($tomorrow->format('Y-m-d'),$course->end_date->format('Y-m-d'));
    }

    public function test_specialist_can_update_course(): void
    {
        $this->seed([MyRolesSeeder::class]);
        $user=User::factory()->has(Specialist::factory()->has(Course::factory()))->create();
        $now = new DateTime();
        $tomorrow = new DateTime();
        $tomorrow->modify('+1 day');

        $data = [
            'name' => 'Test name',
            'selectedDate' =>[
                'start'=>$now->format('Y-m-d'),
                'end' =>$tomorrow->format('Y-m-d')
            ]
            ];
        $course=$user->specialist->courses()->first();
        $response = $this->from('/base/route')->actingAs($user)->put(route('course.update',[$course->id]),$data);
        

        $response->assertRedirect('/base/route')->assertSessionHas('message', ['text' => 'Zaktualizowano szkolenie.', 'status' => 'success']);
        
        $course->refresh();
        $this->assertNotNull($course);
        $this->assertSame($data['name'],$course->name);
        $this->assertSame($now->format('Y-m-d'),$course->start_date->format('Y-m-d'));
        $this->assertSame($tomorrow->format('Y-m-d'),$course->end_date->format('Y-m-d'));
    }
    public function test_user_can_delete_course(): void
    {
        $this->seed([MyRolesSeeder::class]);
        $user=User::factory()->has(Specialist::factory()->has(Course::factory()))->create();

        $course=$user->specialist->courses()->first();
        $response = $this->from('/base/route')->actingAs($user)->delete(route('course.destroy',[$course->id]));
        

        $response->assertRedirect('/base/route')->assertSessionHas('message', ['text' => 'Usunięto szkolenie.', 'status' => 'success']);
        
        
        $this->assertModelMissing($course);
    }
    
}
