<?php

namespace Database\Seeders;

use App\Imports\MedicinesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            RepositorySeeder::class,
            RepositoryUserSeeder::class,
            PermissionsSeeder::class,
            RepositoryUserPermissionsSeeder::class,
            Pharmaceutical_FormSeeder::class,
            LaboratorySeeder::class,
//            MedicineSeeder::class,
        ]);

        $path = storage_path('app/public/MedicineExcel/medicines.xlsx');

        Excel::import(new MedicinesImport, $path);

    }
}
