<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyStock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PharmacyStockTestSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ صيدلية واحدة
        $pharmacy = Pharmacy::first() ?? Pharmacy::factory()->create();

        // 2️⃣ 10 أدوية (إن لم توجد كافية نُنشئ بالباقي Factory)
        $medicines = Medicine::take(10)->get();
        if ($medicines->count() < 10) {
            $more = 10 - $medicines->count();
            $medicines = $medicines->concat(Medicine::factory()->count($more)->create());
        }

        // 3️⃣ إنشاء دفعتين لكل دواء
        $batches = collect();
        foreach ($medicines as $index => $med) {
            // قريبة الانتهاء
            $batches->push(
                Batch::create([
                    'medicine_id' => $med->id,
                    'batch_no' => 'BN-EX' . Str::padLeft($index, 3, '0'),
                    'expiry_date' => Carbon::now()->addDays(rand(5, 25)),
                    'initial_qty' => 50,
                ])
            );
            // بعيدة الانتهاء
            $batches->push(
                Batch::create([
                    'medicine_id' => $med->id,
                    'batch_no' => 'BN-LX' . Str::padLeft($index, 3, '0'),
                    'expiry_date' => Carbon::now()->addMonths(rand(3, 18)),
                    'initial_qty' => 50,
                ])
            );
        }

        // 4️⃣ 20 سجلّ مخزون: 10 منخفضة، 10 طبيعية
        foreach ($batches->take(10) as $batch) {
            PharmacyStock::create([
                'pharmacy_id' => $pharmacy->id,
                'batch_id' => $batch->id,
                'qty_on_hand' => rand(1, 5),   // < 6 علب
                'updated_at' => now(),
            ]);
        }

        foreach ($batches->skip(10)->take(10) as $batch) {
            PharmacyStock::create([
                'pharmacy_id' => $pharmacy->id,
                'batch_id' => $batch->id,
                'qty_on_hand' => rand(6, 20),  // >= 6 علب
                'updated_at' => now(),
            ]);
        }
    }
}
