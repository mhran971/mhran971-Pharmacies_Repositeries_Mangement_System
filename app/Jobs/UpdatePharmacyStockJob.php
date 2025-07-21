<?php

namespace App\Jobs;

use App\Models\PharmacyStock;
use App\Models\StockMovement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdatePharmacyStockJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public StockMovement $movements)
    {
    }


    public function handle(): void
    {
        try {
            // جلب المخزون بناءً على الدواء والصيدلية والدفعة
            $stock = PharmacyStock::where('medicine_id', $this->movements->medicine_id)
                ->where('pharmacy_id', $this->movements->pharmacy_id)
                ->where('batch', $this->movements->batch)
                ->lockForUpdate()
                ->first();

            if (!$stock) {
                $medicine = \App\Models\Medicine::find($this->movements->medicine_id);
                $medicineName = $medicine ? $medicine->name_ar ?? $medicine->name_en : 'دواء غير معروف';

                throw new \Exception("الدواء '{$medicineName}' بالدفعة '{$this->movements->batch}' غير موجود في مخزون الصيدلية.");
            }

            if ($stock->quantity < $this->movements->quantity) {
                throw new \Exception("لا يمكن الخصم من '{$stock->medicine->trade_name}': الكمية المطلوبة ({$this->movements->quantity}) أكبر من المتوفرة ({$stock->quantity}).");
            }

            // خصم الكمية
            $stock->decrement('quantity', $this->movements->quantity);
        } catch (\Exception $e) {
            \Log::error('UpdatePharmacyStockJob failed', [
                'movement_id' => $this->movements->id ?? null,
                'medicine_id' => $this->movements->medicine_id ?? null,
                'pharmacy_id' => $this->movements->pharmacy_id ?? null,
                'batch' => $this->movements->batch ?? null,
                'quantity' => $this->movements->quantity ?? null,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

}
