<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
    }
}
