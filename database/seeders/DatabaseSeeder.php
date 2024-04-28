<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Specialist;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        $this->call([RolesSeeder::class, ProvinceSeeder::class, CategorySeeder::class, ServiceKindSeeder::class]);
        
        User::factory(10)->create();
        User::factory(10)->has(Specialist::factory())->create();
        
        $user=User::factory()->has(Address::factory())->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory()->create([
            'name' => 'Konrad',
            'surname' => 'Strauss',
            'email' => 'shrimpinweb@gmail.com',
            'password'=>Hash::make('Password123'),
        ]);


    }
}
