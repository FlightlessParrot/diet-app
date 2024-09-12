<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use App\Models\Specialist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Specialist::all() as $specialist)
        {
            $socialMedia = SocialMedia::factory()->create(['specialist_id'=>$specialist->id]);
        }
    }
}
