<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\Repository;
use App\Models\RepositoryStock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepositoryStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $medicines = Medicine::pluck('id')->all();
        $pharmacies = Repository::pluck('id')->all();

        \Illuminate\Support\Facades\DB::transaction(function () use ($medicines, $pharmacies) {
            for ($i = 0; $i < 10; $i++) {
                RepositoryStock::create([
                    'medicine_id' => fake()->randomElement($medicines),
                    'repository_id' => 41,
                    'quantity' => fake()->numberBetween(10, 100),
                    'batch' => strtoupper(fake()->bothify('BATCH###')),
                    'Purchase_price' => fake()->randomFloat(2, 1, 50),
                    'sale_price' => fake()->randomFloat(2, 51, 100),
                    'expiration_date' => fake()->dateTimeBetween('+1 month', '+1 year')->format('Y-m-d'),
                ]);
            }
        });
    }
}
