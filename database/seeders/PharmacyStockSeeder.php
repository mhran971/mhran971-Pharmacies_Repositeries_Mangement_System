<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyStock;
use Illuminate\Database\Seeder;

class PharmacyStockSeeder extends Seeder
{

    public function run(): void
    {
        $medicines = Medicine::pluck('id')->all();
        $pharmacies = Pharmacy::pluck('id')->all();

        \Illuminate\Support\Facades\DB::transaction(function () use ($medicines, $pharmacies) {
            for ($i = 0; $i < 10; $i++) {
                PharmacyStock::create([
                    'medicine_id' => fake()->randomElement($medicines),
                    'pharmacy_id' => fake()->randomElement($pharmacies),
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
