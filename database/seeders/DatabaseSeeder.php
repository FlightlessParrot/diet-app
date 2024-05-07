<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\MyRole;
use App\Models\Province;
use App\Models\Specialist;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        $this->call([MyRolesSeeder::class, ProvinceSeeder::class, CategorySeeder::class, ServiceKindSeeder::class]);
        
        User::factory(10)->create();
        $users=User::factory(10)->has(Specialist::factory()->has(Address::factory(2)))
        ->create(['my_role_id'=>MyRole::where('name', 'specialist')->first()->id]);
        foreach($users as $user)
        {
            $user->specialist->serviceCities()->create(['name'=>fake()->city(),'province_id'=>Province::first()->id]);
            $user->specialist->serviceKinds()->attach([0,1,2]);
        }
        User::factory()->has(Address::factory())->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $user=User::factory()->create([
            'name' => 'Konrad',
            'surname' => 'Strauss',
            'email' => 'shrimpinweb@gmail.com',
            'password'=>Hash::make('Password123'),
        ]);

    }
}
