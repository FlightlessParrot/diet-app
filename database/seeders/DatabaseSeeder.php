<?php

namespace Database\Seeders;

use App\Enums\Title;
use App\Events\SpecialistActivated;
use App\Models\Address;
use App\Models\Category;
use App\Models\Description;
use App\Models\Language;
use App\Models\MyRole;
use App\Models\Phone;
use App\Models\Price;
use App\Models\Province;
use App\Models\ServiceKind;
use App\Models\SocialMedia;
use App\Models\Specialist;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\File;
use Orchid\Platform\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([MyRolesSeeder::class, ProvinceSeeder::class, CategorySeeder::class, 
        ServiceKindSeeder::class, OfferSeeder::class]);

        User::factory(30)->has(Phone::factory())->create();
        $users = User::factory(20)->has(
            Specialist::factory()->has(Phone::factory())->has(Address::factory(2))->has(Price::factory(random_int(0, 20)))->
            has(Description::factory())->has(Language::factory(2))
            )->has(Phone::factory())
            ->create(['my_role_id' => MyRole::where('name', 'specialist')->first()->id]);

        $serviceKinds = ServiceKind::all();
        $categories = Category::all();
        $oldIcons = Storage::files('public/specialist/icons/');
        $oldAvatars = Storage::files('public/specialist/avatars/');
        Storage::delete($oldIcons);
        Storage::delete($oldAvatars);
        foreach ($users as $user) {

            SpecialistActivated::dispatch($user->specialist);
            $file = new UploadedFile('storage/app/public/test/man.jpg', 'man.jpg');
            $path = 'specialist/avatars';
            $attachment = (new File($file))->path($path)->load();
            $user->specialist->attachment()->attach($attachment);

            $iconFile = new UploadedFile('storage/app/public/test/man_icon.jpg', 'man_icon.jpg');
            $path = Storage::disk('public')->putFile('specialist/icons', $iconFile);
            $url = Storage::url($path);
            $icon = $user->specialist->icon()->create(['path' => $path, 'url' => $url]);

            if (rand() % 2 === 0) {
                for ($i = 0; $i < 3; $i++) {
                    $user->specialist->serviceCities()->create(['name' => fake()->city(), 'province_id' => Province::first()->id]);
                }


                $user->specialist->serviceKinds()->attach($serviceKinds->where('name', 'mobile'));
            }


            if (rand() % 2 === 0) {
                $user->specialist->serviceKinds()->attach($serviceKinds->where('name', 'stationary'));
            }

            if (rand() % 2 === 0) {
                $user->specialist->serviceKinds()->attach($serviceKinds->where('name', 'online'));
            }

            $user->specialist->categories()->attach($categories->random(2));
        }


        User::factory()->has(Phone::factory())->has(Address::factory())->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=>'password'
        ]);
        
        $user = User::factory()->has(Phone::factory())->has(Address::factory(2))->has(
            Specialist::factory(['title' =>  Title::MGR_INZ->value, 'name' => 'Konrad', 'surname' => 'Strauss'])->has(Phone::factory())
            ->has(Address::factory(2))->has(Price::factory(random_int(0, 20)))->has(Description::factory())->has(Language::factory(2)))
            ->create([
                'name' => 'Konrad',
                'surname' => 'Strauss',
                'email' => 'shrimpinweb@gmail.com',
                'password' => Hash::make('Password123'),
            ]);
        $this->call([BookingSeeder::class, ReviewSeeder::class,  StatisticSeeder::class, CourseSeeder::class, TargetSeeder::class, 
        DocumentSeeder::class, FollowersSeeder::class, FavouritePriceSeeder::class, CommerceSeeder::class, SocialMediaSeeder::class]);
    }
}
