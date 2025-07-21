<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkSalesMovementRequest;
use App\Jobs\UpdatePharmacyStockJob;
use App\Services\Pharmacy\Operation\SalesMovementService as OperationSalesMovementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesMovementController extends Controller
{

    protected OperationSalesMovementService $service;

    public function __construct(OperationSalesMovementService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
            'batch' => 'required|string',
        ]);

        $movement = $this->service->create($validated);

        return response()->json(['data' => $movement], 201);
    }

    public function bulkStore(BulkSalesMovementRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;
        $items = $validated['items'];

        $movements = [];
        $errors = [];

        foreach ($items as $item) {
            try {
                $movement = $this->service->createWithEarliestBatch(
                    $pharmacyId,
                    $user->id,
                    $item['medicine_id'],
                    $item['quantity'],
                    $item['batch'],
                );
                $movements[] = $movement;
            } catch (\Exception $e) {
                $medicine = \App\Models\Medicine::find($item['medicine_id']);
                $errors[] = [
                    'medicine_id' => $item['medicine_id'],
                    'medicine_name' => $medicine->trade_name ?? 'دواء غير معروف',
                    'requested_quantity' => $item['quantity'],
                    'message' => $e->getMessage(),
                ];
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'message' => 'بعض الأدوية غير متوفرة بالكميات المطلوبة.',
                'errors' => $errors,
            ], 422);
        }
        UpdatePharmacyStockJob::dispatch($movement);

        return response()->json(['data' => $movements], 201);
    }
}
