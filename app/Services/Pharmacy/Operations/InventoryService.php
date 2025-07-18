<?php

namespace App\Services\Pharmacy\Operations;

use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public function adjustStock(int $ph, int $batch, string $type, int $qty)
    {
        DB::retry(3, fn() => StockMovement::create([
            'pharmacy_id' => $ph,
            'batch_id' => $batch,
            'type' => $type,
            'qty' => $qty,
            'user_id' => auth()->id(),
        ])
            , 100);
    }
}
