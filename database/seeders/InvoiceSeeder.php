<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        // Insert 10 sample invoices
        DB::table('invoices')->insert([
            [
                'pharmacy_id' => '1',
                'user_id' => '1',
                'total_sum' => 100.50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pharmacy_id' => '2',
                'user_id' => '2',
                'total_sum' => 250.75,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pharmacy_id' => '3',
                'user_id' => '3',
                'total_sum' => 75.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pharmacy_id' => '1',
                'user_id' => '4',
                'total_sum' => 150.25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pharmacy_id' => '2',
                'user_id' => '5',
                'total_sum' => 300.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pharmacy_id' => '3',
                'user_id' => '6',
                'total_sum' => 50.99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pharmacy_id' => '1',
                'user_id' => '7',
                'total_sum' => 200.10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pharmacy_id' => '2',
                'user_id' => '8',
                'total_sum' => 175.50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pharmacy_id' => '3',
                'user_id' => '9',
                'total_sum' => 125.75,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pharmacy_id' => '1',
                'user_id' => '10',
                'total_sum' => 90.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
