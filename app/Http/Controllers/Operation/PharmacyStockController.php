<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMedicineRequest;
use App\Http\Requests\ReturnedMedicineRequest;
use App\Models\Medicine;
use App\Models\PharmacyStock;
use App\Models\StockMovement;
use App\Services\Pharmacy\Operation\Add_To_StockService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PharmacyStockController extends Controller
{
    protected Add_To_StockService $Add_To_StockService;

    public function __construct(Add_To_StockService $Add_To_StockService)
    {
        $this->Add_To_StockService = $Add_To_StockService;
    }

    public function pharmacy_stock()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        $stocks = \App\Models\PharmacyStock::with(['medicine', 'pharmacy.pharmacists'])
            ->when($pharmacyId, fn($q) => $q->where('pharmacy_id', $pharmacyId))
            ->whereHas('pharmacy', function ($query) use ($user) {
                $query->where('owner_id', $user->id);
            })
            ->get()
            ->each(function ($item) {
                $item->makeHidden('pharmacy');
            });

        return response()->json(['data' => $stocks]);
    }

    public function Add_To_stock(AddMedicineRequest $med)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        $existingStockIds = PharmacyStock::where('pharmacy_id', $pharmacyId)
            ->pluck('medicine_id')
            ->toArray();

        $items = $med->validated()['items'];
        $stocks = [];
        $skipped = [];

        $seenInRequest = [];

        $medicinesMap = Medicine::whereIn('id', array_column($items, 'medicine_id'))
            ->pluck('trade_name', 'id')
            ->toArray();

        foreach ($items as $item) {
            $medicineId = $item['medicine_id'];

            if (in_array($medicineId, $existingStockIds)) {
                $skipped[] = [
                    'medicine_id' => $medicineId,
                    'medicine_name' => $medicinesMap[$medicineId] ?? null,
                    'reason' => 'Already exists in stock'
                ];
                continue;
            }

            if (in_array($medicineId, $seenInRequest)) {
                $skipped[] = [
                    'medicine_id' => $medicineId,
                    'medicine_name' => $medicinesMap[$medicineId] ?? null,
                    'reason' => 'Duplicate in request'
                ];
                continue;
            }

            $seenInRequest[] = $medicineId;

            $stocks[] = $this->Add_To_StockService->Add_medicine($pharmacyId, $item);
        }

        return response()->json([
            'added' => $stocks,
            'skipped' => $skipped
        ]);
    }


    public function Returned_Medicine(ReturnedMedicineRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;
        $medicineId = $request->input('medicine_id');
        $quantityToReturn = $request->input('quantity');

        $previousQuantity = PharmacyStock::where('medicine_id', $medicineId)
            ->where('pharmacy_id', $pharmacyId)
            ->value('quantity');

        if ($previousQuantity === null) {
            return response()->json(['error' => 'Medicine not found in stock'], 404);
        }
       $data = DB::Transaction(function () use ($medicineId, $pharmacyId, $user, $quantityToReturn) {
            StockMovement::Where('medicine_id', $medicineId)
                ->where('pharmacy_id', $pharmacyId)
                ->where('user_id', $user->id)
                ->delete();

            PharmacyStock::where('medicine_id', $medicineId)
                ->where('pharmacy_id', $pharmacyId)
                ->increment('quantity', $quantityToReturn);

            $newQuantity = PharmacyStock::where('medicine_id', $medicineId)
                ->where('pharmacy_id', $pharmacyId)
                ->value('quantity');

            $medicineName = Medicine::where('id', $medicineId)->value('trade_name');


            return [
                'medicineName' => $medicineName,
                'newQuantity' => $newQuantity
            ];
        });
        return response()->json([
            'medicine'          => $data['medicineName'],
            'previous_quantity' => $previousQuantity,
            'new_quantity'      => $data['newQuantity']
        ]);
    }

    public function expiringSoon()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = null;

        if ($user->pharmacy_owner) {
            $pharmacyId = $user->pharmacy_owner->id;
        } elseif ($user->pharmacists()->exists()) {
            $pharmacyId = $user->pharmacists()->first()->id;
        }

        if (!$pharmacyId) {
            return response()->json(['error' => 'Pharmacy not found'], 404);
        }

        $soon = \App\Models\PharmacyStock::with(['medicine', 'pharmacy.pharmacists'])
            ->where('pharmacy_id', $pharmacyId)
            ->whereDate('expiration_date', '<=', now()->addDays(30))
            ->orderBy('expiration_date')
            ->get()
            ->each(function ($item) {
                $item->makeHidden('pharmacy');
            });

        return response()->json(['data' => $soon]);
    }


    public function lowStock()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = null;

        if ($user->pharmacy_owner) {
            $pharmacyId = $user->pharmacy_owner->id;
        } elseif ($user->pharmacists()->exists()) {
            $pharmacyId = $user->pharmacists()->first()->id;
        }

        if (!$pharmacyId) {
            return response()->json(['error' => 'Pharmacy not found'], 404);
        }

        $soon = \App\Models\PharmacyStock::with(['medicine', 'pharmacy.pharmacists'])
            ->where('pharmacy_id', $pharmacyId)
            ->where('quantity', '<=', 10)
            ->orderBy('expiration_date')
            ->get()
            ->each(function ($item) {
                $item->makeHidden('pharmacy');
            });

        return response()->json(['data' => $soon]);
    }


}
