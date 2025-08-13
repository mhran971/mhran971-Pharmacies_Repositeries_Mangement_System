<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMedicineRequest;
use App\Services\Pharmacy\Operation\Add_To_StockService;
use Illuminate\Support\Facades\Auth;


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
        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $items = $med->validated()['items'];

        foreach ($items as $item) {
            $stocks[] = $this->Add_To_StockService->Add_medicine($pharmacyId, $item);
        }
        return response()->json(['data' => $stocks]);
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
