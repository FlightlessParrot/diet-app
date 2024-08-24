<?php

namespace Database\Seeders;

use App\Models\Specialist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users= User::all();
        $specialists=Specialist::all();
        $bestSpecialists=$specialists->random(20)->filter(fn (Specialist $specialist)=>$specialist->id);

        foreach($users as $user)
        {
            $user->favouriteSpecialists()->attach($bestSpecialists);  
        }
    }
}
