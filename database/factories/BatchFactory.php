<?php

namespace Database\Factories;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BatchFactory extends Factory
{
    protected $model = Batch::class;

    public function definition()
    {
        return [
            'medicine_id' => null, // You may want to set this to a valid medicine id or factory
            'batch_no' => 'BN-' . Str::upper($this->faker->bothify('??###')),
            'expiry_date' => Carbon::now()->addMonths(rand(1, 24)),
            'initial_qty' => $this->faker->numberBetween(10, 100),
        ];
    }
}
