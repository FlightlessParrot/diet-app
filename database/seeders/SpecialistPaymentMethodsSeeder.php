<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialistPaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialists = Specialist::all();

        foreach ($specialists as $specialist)
        {
            $specialist->paymentMethods()->create(['name'=>'karta']);
            $specialist->paymentMethods()->create(['name'=>'gotówka']);
        }
    }
}
