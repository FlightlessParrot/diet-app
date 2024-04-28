<?php

namespace Database\Seeders;

use App\Models\ServiceKind;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceKindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceKind::create(
            ['name'=>'mobile']
        );
        ServiceKind::create(
            ['name'=>'online']
        );
        ServiceKind::create(
            ['name'=>'stationary']
        );
    }
}
