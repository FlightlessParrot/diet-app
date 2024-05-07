<?php

namespace Database\Seeders;

use App\Models\MyRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MyRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MyRole::create(['name'=>'admin']);
        MyRole::create(['name'=> 'user']);
        MyRole::create(['name'=> 'specialist']);
    }
}
