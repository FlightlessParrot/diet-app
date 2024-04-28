<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    private $provinceNames;
    /**
     * Run the database seeds.
     */
    public function __construct()
    {
        $this->provinceNames = [
            'Dolnośląskie',
            'Kujawsko-pomorskie',
            'Lubelskie',
            'Lubuskie',
            'Łódzkie',
            'Małopolskie',
            'Mazowieckie',
            'Opolskie',
            'Podkarpackie',
            'Podlaskie',
            'Pomorskie',
            'Śląskie',
            'Świętokrzyskie',
            'Warmińsko-mazurskie',
            'Wielkopolskie',
            'Zachodniopomorskie'
        ];
    }
    public function run(): void
    {
        foreach( $this->provinceNames as $provinceName ){
            $province = new Province();
            $province->name= $provinceName;
            $province->save();
        }
    }
}
