<?php

namespace App\Services\Pharmacy\Operation;

use App\Models\Sales_movements;

class Add_To_StockService
{
    public function Add_medicine($pharmacyId, $item)
    {
        return $stocks = \App\Models\PharmacyStock::updateorcreate([
            'medicine_id' => $item['medicine_id'],
            'pharmacy_id' => $pharmacyId,
            'batch' => $item['batch'],
        ],
            [
                'quantity' => $item['quantity'],
                'Purchase_price' => $item['Purchase_price'],
                'sale_price' => $item['sale_price'],
                'expiration_date' => $item['expiration_date'],
            ]);

    }
}
