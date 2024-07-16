<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialists=Specialist::all();
        foreach($specialists as $key => $specialist)
        {
            for($i=0;$i<4;$i++)
            {
                $course = Course::factory()->make();
                $specialist->courses()->save($course);
            }
                
           
        }
    }
}
