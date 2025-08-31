<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Database\Seeder;

class SalesMovementSeeder extends Seeder
{
    public function run(): void
    {
        $medicines = Medicine::pluck('id')->all();
        $pharmacies = Pharmacy::pluck('id')->all();
        $users = User::pluck('id')->all();
        $invoices = Invoice::pluck('id')->all();

        for ($i = 0; $i < 10; $i++) {
            StockMovement::create([
                'medicine_id' => fake()->randomElement($medicines),
                'pharmacy_id' => fake()->randomElement($pharmacies),
                'user_id' => fake()->randomElement($users),
                'invoice_id' => fake()->randomElement($invoices),
                'quantity' => fake()->numberBetween(1, 100),
                'batch' => strtoupper(fake()->bothify('??###')),
            ]);
        }
    }
}
