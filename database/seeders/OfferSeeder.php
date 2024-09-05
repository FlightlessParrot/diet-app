<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Offer::factory()->create(['name'=>'Pakiet dla oszczędnych', 'duration'=>1]);
       Offer::factory()->create(['name'=>'Pakiet standardowy']);
       Offer::factory()->create(['name'=>'Super oferta', 'duration'=>12]);
    }
}
