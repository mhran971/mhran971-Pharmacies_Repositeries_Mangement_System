<?php

namespace App\Services\Pharmacy\Operation;

use App\Jobs\UpdatePharmacyStockJob;
use App\Models\PharmacyStock;
use App\Models\Sales_movements;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class SalesMovementService
{
    public function createWithEarliestBatch(int $pharmacyId, int $userId, int $medicineId, int $quantity, $batch): StockMovement
    {
        return DB::transaction(function () use ($pharmacyId, $userId, $medicineId, $quantity, $batch) {
            $stock = PharmacyStock::where('pharmacy_id', $pharmacyId)
                ->where('medicine_id', $medicineId)
                ->where('batch', $batch)
                ->first();

            if (!$stock) {
                throw new \Exception("الدواء غير متوفر في المخزون بالدفعة المحددة.");
            }

            if ($stock->quantity < $quantity) {
                throw new \Exception("الكمية المطلوبة غير متوفرة في المخزون.");
            }

            $movement = StockMovement::create([
                'medicine_id' => $medicineId,
                'pharmacy_id' => $pharmacyId,
                'user_id' => $userId,
                'quantity' => $quantity,
                'batch' => $batch,
            ]);

            UpdatePharmacyStockJob::dispatch($movement);

            return $movement;
        });
    }
}
