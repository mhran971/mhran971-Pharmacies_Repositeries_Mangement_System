<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplements = [

            ['medicine_id_1' => '5135', 'medicine_id_2' => '11889'],
            ['medicine_id_1' => '7809', 'medicine_id_2' => '632'],
            ['medicine_id_1' => '1909', 'medicine_id_2' => '478'],
            ['medicine_id_1' => '454', 'medicine_id_2' => '7962'],
            ['medicine_id_1' => '8152', 'medicine_id_2' => '9642'],
            ['medicine_id_1' => '8771', 'medicine_id_2' => '6186'],
            ['medicine_id_1' => '12492', 'medicine_id_2' => '12172'],


        ];
        collect($supplements)->chunk(15)->each(function ($chunk) {
            DB::table('supplements')->insert($chunk->toArray());
        });
    }
}
