<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialists = Specialist::doesntHave('statistic')->get();

        foreach ($specialists as $specialist)
        {
            $specialist->statistic()->create();
        }
    }
}
