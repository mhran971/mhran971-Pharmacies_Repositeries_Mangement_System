<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlternativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alternatives = [
            ['medicine_id_1' => 2412, 'medicine_id_2' => 934],
            ['medicine_id_1' => 6148, 'medicine_id_2' => 11916],
            ['medicine_id_1' => 11916, 'medicine_id_2' => 6148],
            ['medicine_id_1' => 1392, 'medicine_id_2' => 31],
            ['medicine_id_1' => 12624, 'medicine_id_2' => 3376],
            ['medicine_id_1' => 8771, 'medicine_id_2' => 3777],
            ['medicine_id_1' => 7866, 'medicine_id_2' => 11849],
            ['medicine_id_1' => 4416, 'medicine_id_2' => 3874],
            ['medicine_id_1' => 13223, 'medicine_id_2' => 3497],
            ['medicine_id_1' => 3777, 'medicine_id_2' => 8771],
            ['medicine_id_1' => 11849, 'medicine_id_2' => 7866],
            ['medicine_id_1' => 3357, 'medicine_id_2' => 7749],
        ];

        DB::table('alternatives')->insert($alternatives);
    }
}
