<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Pharmacy_User;
use App\Models\PharmacyUserPermission;
use Illuminate\Database\Seeder;

class PharmacyUserPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = Permission::pluck('id')->all();
        $pharmacyUsers = Pharmacy_User::pluck('id')->all();

        if (empty($permissions) || empty($pharmacyUsers)) {
            return; // Skip if no data
        }

        for ($i = 0; $i < 20; $i++) {
            PharmacyUserPermission::create([
                'permission_id' => fake()->randomElement($permissions),
                'pharmacy_user_id' => fake()->randomElement($pharmacyUsers),
            ]);
        }
    }
}
