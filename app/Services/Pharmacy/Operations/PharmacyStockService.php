<?php

namespace App\Services\Pharmacy\Operations;

use App\Models\PharmacyStock;
use App\Models\StockMovement;

class PharmacyStockService
{
    public function updateStock(StockMovement $m): void
    {
        $ph = $m->pharmacy_id;
        $batch = $m->batch_id;

        $newQty = StockMovement::where('pharmacy_id', $ph)
            ->where('batch_id', $batch)
            ->selectRaw("SUM(CASE WHEN type='IN' THEN qty ELSE -qty END) as stock")
            ->value('stock') ?: 0;

        PharmacyStock::updateOrCreate(
            ['pharmacy_id' => $ph, 'batch_id' => $batch],
            ['qty_on_hand' => $newQty, 'updated_at' => now()]
        );
    }
}
