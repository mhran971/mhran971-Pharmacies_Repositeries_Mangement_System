<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('invoices')->insert([
            [
                'pharmacy_id'        => 1,
                'user_id'            => 1,
                'costumer_fullName'  => 'أحمد علي',
                'National_number'    => '123456789',
                'invoice_num'        => 10001,
                'total_sum'          => 100.50,
                'Psychiatric'        => false,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'pharmacy_id'        => 2,
                'user_id'            => 2,
                'costumer_fullName'  => 'محمد يوسف',
                'National_number'    => '223456789',
                'invoice_num'        => 10002,
                'total_sum'          => 250.75,
                'Psychiatric'        => true,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'pharmacy_id'        => 3,
                'user_id'            => 3,
                'costumer_fullName'  => 'خالد حسن',
                'National_number'    => '323456789',
                'invoice_num'        => 10003,
                'total_sum'          => 75.00,
                'Psychiatric'        => false,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'pharmacy_id'        => 1,
                'user_id'            => 4,
                'costumer_fullName'  => 'مروان سامي',
                'National_number'    => '423456789',
                'invoice_num'        => 10004,
                'total_sum'          => 150.25,
                'Psychiatric'        => true,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'pharmacy_id'        => 2,
                'user_id'            => 5,
                'costumer_fullName'  => 'ليلى خالد',
                'National_number'    => '523456789',
                'invoice_num'        => 10005,
                'total_sum'          => 300.00,
                'Psychiatric'        => false,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'pharmacy_id'        => 3,
                'user_id'            => 6,
                'costumer_fullName'  => 'سعاد محمد',
                'National_number'    => '623456789',
                'invoice_num'        => 10006,
                'total_sum'          => 50.99,
                'Psychiatric'        => false,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'pharmacy_id'        => 1,
                'user_id'            => 7,
                'costumer_fullName'  => 'زياد فؤاد',
                'National_number'    => '723456789',
                'invoice_num'        => 10007,
                'total_sum'          => 200.10,
                'Psychiatric'        => true,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'pharmacy_id'        => 2,
                'user_id'            => 8,
                'costumer_fullName'  => 'منى أحمد',
                'National_number'    => '823456789',
                'invoice_num'        => 10008,
                'total_sum'          => 175.50,
                'Psychiatric'        => false,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'pharmacy_id'        => 3,
                'user_id'            => 9,
                'costumer_fullName'  => 'رامي علاء',
                'National_number'    => '923456789',
                'invoice_num'        => 10009,
                'total_sum'          => 125.75,
                'Psychiatric'        => true,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'pharmacy_id'        => 1,
                'user_id'            => 10,
                'costumer_fullName'  => 'فاطمة سمير',
                'National_number'    => '103456789',
                'invoice_num'        => 10010,
                'total_sum'          => 90.00,
                'Psychiatric'        => false,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
        ]);
    }
}
