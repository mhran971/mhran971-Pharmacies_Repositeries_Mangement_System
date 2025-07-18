<?php

namespace Database\Factories;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    protected $model = Medicine::class;

    public function definition()
    {
        return [
            'trade_name' => $this->faker->word,
            'laboratory_id' => null, // You may want to set this to a valid laboratory id or factory
            'composition' => $this->faker->sentence,
            'titer' => $this->faker->randomFloat(2, 0, 100),
            'packaging' => $this->faker->word,
            'pharmaceutical_form_id' => null, // You may want to set this to a valid pharmaceutical form id or factory
        ];
    }
}
