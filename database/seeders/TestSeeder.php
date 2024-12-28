<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Description;
use App\Models\Language;
use App\Models\MyRole;
use App\Models\Phone;
use App\Models\Price;
use App\Models\Province;
use App\Models\ServiceKind;
use App\Models\Specialist;
use App\Models\Specialization;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([SpecializationSeeder::class,MyRolesSeeder::class, ProvinceSeeder::class, CategorySeeder::class, ServiceKindSeeder::class, OfferSeeder::class]);
        
        User::factory(30)->has(Phone::factory())->create();
        $users = User::factory(20)->has(Specialist::factory()->has(Phone::factory())->has(Address::factory(2))->has(Price::factory(random_int(0, 20)))->
            has(Description::factory())->has(Language::factory(2)))->has(Phone::factory())
            ->create(['my_role_id' => MyRole::where('name', 'specialist')->first()->id]);

        $serviceKinds=ServiceKind::all();
        $categories = Category::all();
        foreach($users as $user)
        {
          
            
            if(rand()%2===0)
            {
                for($i=0;$i<3;$i++)
                {
                   $user->specialist->serviceCities()->create(['name'=>fake()->city(),'province_id'=>Province::first()->id]); 
                }
               

                $user->specialist->serviceKinds()->attach($serviceKinds->where('name','mobile'));
            }
            

            if(rand()%2===0)
            {
                $user->specialist->serviceKinds()->attach($serviceKinds->where('name','stationary'));
            }

            if(rand()%2===0)
            {
                $user->specialist->serviceKinds()->attach($serviceKinds->where('name','online'));
            }

            $user->specialist->categories()->attach($categories->random(2));
            $specializations=Specialization::all();
            $user->specialist->specializations()->attach($specializations->random(2));
        }
       

        $this->call([BookingSeeder::class, ReviewSeeder::class, StatisticSeeder::class, 
        TargetSeeder::class, FollowersSeeder::class,FavouritePriceSeeder::class]);
    }
    
}
