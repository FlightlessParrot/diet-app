<?php

namespace Database\Seeders;

use App\Models\Address;
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
        $this->call(RolesSeeder::class);
        User::factory(10)->create();
        $user=User::factory()->has(Address::factory())->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory()->create([
            'name' => 'Konrad',
            'email' => 'shrimpinweb@gmail.com',
                'password'=>Hash::make('Password123'),
        ]);


    }
}
