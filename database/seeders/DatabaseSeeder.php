<?php

namespace Database\Seeders;

use App\Imports\MedicinesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;


class DatabaseSeeder extends Seeder
{
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
        ]);

        $excelPath = storage_path('app/public/MedicineExcel/medicines.xlsx');
        Excel::import(new MedicinesImport, $excelPath);
        $this->command->info('   Medicines Importing...');

        $this->call([
            PharmacySeeder::class,
            PharmacyUserSeeder::class,
            SalesMovementSeeder::class,
            PharmacyStockSeeder::class,
        ]);
    }
}
