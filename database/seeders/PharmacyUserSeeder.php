<?php

namespace Database\Seeders;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacyUserSeeder extends Seeder
{
    public function run(): void
    {
        $pharmacies = Pharmacy::inRandomOrder()->take(10)->get();
        $users = User::inRandomOrder()->take(10)->get();

        foreach ($pharmacies as $pharmacy) {
            $user = $users->random();

            DB::table('pharmacy_users')->insert([
                'pharmacy_id' => $pharmacy->id,
                'user_id' => $user->id,
                'role' => fake()->randomElement(['pharmacist', 'assistant']),
                'is_work' => fake()->boolean(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
