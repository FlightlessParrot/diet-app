<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavouritePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialists=Specialist::has('prices')->get();

        foreach($specialists as $specialist)
        {
            $price=$specialist->prices()->first();
            if($price)
            {
                $specialist->favouritePrice()->associate($price->id);
                $specialist->save();
            }
            
        }
    }
}
