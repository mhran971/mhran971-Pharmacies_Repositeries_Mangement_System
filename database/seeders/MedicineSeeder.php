<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $titer = [100, 200, 500, 1000];
        $medicines = [];

        for ($i = 0; $i < 10; $i++) {
            $medicines[] = [
                'trade_name' => fake()->userName(),
                'laboratory_id' => rand(5, 25),
                'composition' => fake()->name(),
                'titer' => Arr::random($titer),
                'packaging' => fake()->name(),
                'pharmaceutical_form_id' => rand(5, 25),
            ];
        }

        collect($medicines)->chunk(100)->each(function ($chunk) {
            DB::table('medicines')->insert($chunk->toArray());
        });
    }
}
