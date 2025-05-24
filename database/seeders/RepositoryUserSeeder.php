<?php

namespace Database\Seeders;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepositoryUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $repositories = Repository::all();
        $users = User::all();

        for ($i = 0; $i < 20; $i++) {
            \App\Models\Repository_User::create([
                'user_id' => $users->random()->id,
                'repository_id' => $repositories->random()->id,
                'role' => fake()->randomElement(['admin', 'editor', 'viewer']),
            ]);
        }
    }

}
