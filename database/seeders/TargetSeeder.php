<?php

namespace Database\Seeders;

use App\Models\Specialist;
use App\Models\Target;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $targetNames = [
            'dzieci', 'dorośli', 'osoby starsze'
        ];
        $targets=new Collection();
        foreach( $targetNames as $targetName)
        {
            $target = new Target();
            $target->name = $targetName;

            $target->save();
            $targets->push($target);
        }

        $specialists = Specialist::all();

        foreach ( $specialists as $specialist)
        {
            $targets->shuffle();
            $specialist->targets()->attach([$targets[0]->id,$targets[1]->id]);
        }
    }
}
