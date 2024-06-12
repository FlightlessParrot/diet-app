<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\MyRole;
use App\Models\Province;
use App\Models\ServiceKind;
use App\Models\Specialist;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        $this->call([MyRolesSeeder::class, ProvinceSeeder::class, CategorySeeder::class, ServiceKindSeeder::class]);
        
        User::factory(30)->create();
        $users=User::factory(20)->has(Specialist::factory()->has(Address::factory(2)))
        ->create(['my_role_id'=>MyRole::where('name', 'specialist')->first()->id]);

        $serviceKinds=ServiceKind::all();
        $categories = Category::all();
        foreach($users as $user)
        {
            $file = new UploadedFile('storage/app/public/test/man.jpg', 'man.jpg');
            $path='specialist/avatars';
            $attachment = (new File($file))->path($path)->load();
            $user->specialist->attachment()->attach($attachment);

            $path = Storage::disk('public')->putFile('specialist/icons', $file);  
            $url = Storage::url($path);
            $icon=$user->specialist->icon()->create(['path' => $path, 'url' => $url]);
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
        }
       

        User::factory()->has(Address::factory())->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $user=User::factory()->has(Address::factory(2))->create([
            'name' => 'Konrad',
            'surname' => 'Strauss',
            'email' => 'shrimpinweb@gmail.com',
            'password'=>Hash::make('Password123'),
        ]);

    }
}
