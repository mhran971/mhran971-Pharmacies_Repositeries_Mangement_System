<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepositorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owners = User::inRandomOrder()->take(10)->pluck('id');

        for ($i = 0; $i < 20; $i++) {
            \App\Models\Repository::create([
                'repository_name' => fake()->company(),
                'repository_phone' => fake()->phoneNumber(),
                'repository_address' => fake()->address(),
                'owner_id' => $owners->random(),
            ]);
        }

    }
}
