<?php

namespace Database\Seeders;

use App\Enums\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialization as ModelsSpecialization;
class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases=Specialization::cases();
        $values = array_column($cases,'value');

        foreach($values as $value)
        {
            $specialization = new ModelsSpecialization();

            $specialization->name=$value;
            $specialization->save();
        }
    }
}
