<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\Operations\BulkSalesMovementRequest;
use App\Jobs\UpdatePharmacyStockJob;
use App\Models\Invoice;
use App\Models\PharmacyStock;
use App\Services\Pharmacy\Operation\SalesMovementService as OperationSalesMovementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $movements = [];
        $errors = [];

        try {
            DB::transaction(function () use ($request, &$movements, &$errors) {
                $user = Auth::user();
                $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;
                $items = $request->validated()['items'];
                $totalSum = 0;

                foreach ($items as $item) {
                    $price = PharmacyStock::where('medicine_id', $item['medicine_id'])
                        ->where('pharmacy_id', $pharmacyId)
                        ->where('batch', $item['batch'])
                        ->value('sale_price');

                    $totalSum += $price * $item['quantity'];
                }

                $invoice = Invoice::create([
                    'National_number' => $request->National_number ?? '',
                    'invoice_num' => $request->invoice_num ?? '',
                    'costumer_fullName' => $request->costumer_fullName ?? '',
                    'Psychiatric' => $request->Psychiatric ?? 0,
                    'pharmacy_id' => $pharmacyId,
                    'user_id' => $user->id,
                    'total_sum' => $totalSum,
                ]);

                foreach ($items as $item) {
                    try {
                        $movement = $this->service->createWithEarliestBatch(
                            $pharmacyId,
                            $user->id,
                            $item['medicine_id'],
                            $item['quantity'],
                            $item['batch'],
                            $invoice->id
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
                     throw new \Exception();
                }
            });

            if (!empty($errors)) {
                return response()->json([
                    'message' => 'بعض الأدوية غير متوفرة بالكميات المطلوبة.',
                    'errors' => $errors,
                ], 422);
            }

//             foreach ($movements as $movement) {
//                UpdatePharmacyStockJob::dispatch($movement);
//            }

            return response()->json(['data' => $movements], 201);

        } catch (\Exception $e) {
             return response()->json([
                'message' => 'An error occurred during the process of processing.',
            ], 500);
        }
    }
}
