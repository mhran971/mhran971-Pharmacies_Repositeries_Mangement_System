<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 1; $i <= 10; $i++) {
            $total = rand(100, 1000);
            $paid = rand(50, $total);
            $remaining = $total - $paid;

            Order::create([
                'pharmacy_id' => 10,
                'user_id' => rand(1, 10),
                'repository_id' => rand(1, 3),
                'order_num' => 'ORD-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'status' => ['pending', 'approved', 'rejected', 'delivered'][array_rand(['pending', 'approved', 'rejected', 'delivered'])],
                'total_price' => $total,
                'paid' => $paid,
                'remaining' => $remaining,
            ]);
        }
    }
}
