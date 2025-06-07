<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Repository_Owner'],
            ['name' => 'Pharmacy_Owner'],
            ['name' => 'Repository_Employee'],
            ['name' => 'Pharmacist'],

        ];

        collect($roles)->chunk(15)->each(function ($chunk) {
            DB::table('roles')->insert($chunk->toArray());
        });
    }
}
