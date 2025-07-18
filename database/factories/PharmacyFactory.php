<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacyFactory extends Factory
{
    protected $model = Pharmacy::class;

    public function definition()
    {
        return [
            'pharmacy_name' => $this->faker->company,
            'pharmacy_phone' => $this->faker->phoneNumber,
            'pharmacy_address' => $this->faker->address,
            'owner_id' => User::factory(),
        ];
    }
}
