<?php

namespace App\Http\Controllers;

use App\Enums\MovementType;
use App\Http\Requests\AdjustStockRequest;
use App\Models\PharmacyStock;
use App\Services\Pharmacy\Operations\InventoryService;
use Illuminate\Http\JsonResponse;

class StockMovementsController extends Controller
{

    public function pharmacy_stock($ph): \Illuminate\Http\JsonResponse
    {
        $stocks = PharmacyStock::with('batch.medicine')
            ->where('pharmacy_id', $ph)
            ->get()
            ->map(fn($s) => [
                'batch_no' => $s->batch->batch_no,
                'medicine' => $s->batch->medicine->trade_name,
                'expiry_date' => $s->batch->expiry_date->toDateString(),
                'qty_on_hand' => $s->qty_on_hand,
                'updated_at' => $s->updated_at?->toDateTimeString(),
            ]);
        return response()->json($stocks);
    }


    public function adjust(AdjustStockRequest $request,
                           InventoryService   $inventory, int $pharmacy_id, MovementType $type): JsonResponse
    {
        $inventory->adjustStock(
            $pharmacy_id,
            $request->batch_id,
            $type->value,
            $request->qty
        );

        return response()->json(['message' => 'Adjustment queued.'], 202);
    }

}
