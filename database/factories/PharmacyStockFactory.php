<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use App\Models\PharmacyStock;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacyStockFactory extends Factory
{
    protected $model = PharmacyStock::class;

    public function definition()
    {
        return [
            'pharmacy_id' => Pharmacy::factory(), // You may want to set this to a valid pharmacy id or factory
            'batch_id' => null, // You may want to set this to a valid batch id or factory
            'qty_on_hand' => $this->faker->numberBetween(0, 100),
            'updated_at' => now(),
        ];
    }
}
