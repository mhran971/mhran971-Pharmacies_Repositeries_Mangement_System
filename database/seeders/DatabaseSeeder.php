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
            PermissionsSeeder::class,
            RoleSeeder::class,
            Pharmaceutical_FormSeeder::class,
            LaboratorySeeder::class,
        ]);

        $excelPath = storage_path('app/public/MedicineExcel/medicine.xlsx');
        $this->command->info('   Medicines Importing...');
        Excel::import(new MedicinesImport, $excelPath);

        $this->call([
            UserSeeder::class,
            RepositorySeeder::class,
            RepositoryUserSeeder::class,
            RepositoryUserPermissionsSeeder::class,
            PharmacySeeder::class,
            PharmacyUserSeeder::class,
            InvoiceSeeder::class,
            SalesMovementSeeder::class,
            PharmacyStockSeeder::class,
            PharmacyUserPermissionSeeder::class,
            RepositoryStockSeeder::class,
            AlternativeSeeder::class,
            InteractionSeeder::class,
            SupplementsSeeder::class,
            OrderSeeder::class
        ]);
    }
}
