<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            \App\Models\User::create([
                'name' => fake()->name(),
                'phone_number' => fake()->phoneNumber(),
                'email' => fake()->unique()->safeEmail(),
                'role_id' => random_int(1, 4),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'token' => Str::random(10),
            ]);
        }
    }

}
