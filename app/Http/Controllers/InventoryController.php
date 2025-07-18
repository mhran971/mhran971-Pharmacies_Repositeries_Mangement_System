<?php

namespace App\Http\Controllers;

use App\Models\PharmacyStock;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class InventoryController extends Controller
{
    public function expiringSoon(int $pharmacy_id): JsonResponse
    {
        $thresholdDate = Carbon::now()->addDays(30)->endOfDay();

        $stockItems = PharmacyStock::query()
            ->where('pharmacy_id', $pharmacy_id)
            ->where('qty_on_hand', '>', 0)
            ->whereHas('batch', function ($q) use ($thresholdDate) {
                $q->whereDate('expiry_date', '<=', $thresholdDate);
            })
            ->with(['batch.medicine'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'batch_no' => $item->batch->batch_no,
                    'medicine_name' => $item->batch->medicine->trade_name,
                    'medicine_titer' => $item->batch->medicine->titer,
                    'expiry_date' => $item->batch->expiry_date->toDateString(),
                    'qty_on_hand' => $item->qty_on_hand,
                    'updated_at' => $item->updated_at->toDateTimeString(),
                ];
            });

        return response()->json($stockItems);
    }


    public function lowStock(int $pharmacy_id): JsonResponse
    {
        $stocks = PharmacyStock::with('batch.medicine')
            ->with('batch.medicine.laboratory')
            ->where('pharmacy_id', $pharmacy_id)
            ->where('qty_on_hand', '<=', 10)
            ->orderBy('pharmacy_stocks.id')
            ->get()
            ->map(function ($stock) {
                return [
                    'medicine_id' => $stock->batch->medicine->id ?? null,
                    'trade_name' => $stock->batch->medicine->trade_name ?? null,
                    'composition' => $stock->batch->medicine->composition ?? null,
                    'laboratory_id' => $stock->batch->medicine->laboratory->name_en ?? null,
                    'batch_no' => $stock->batch->batch_no ?? null,
                    'expiry_date' => $stock->batch->expiry_date?->toDateString(),
                    'qty_on_hand' => $stock->qty_on_hand,
                    'updated_at' => $stock->updated_at?->toDateTimeString(),
                ];
            });

        return response()->json($stocks);
    }


}
