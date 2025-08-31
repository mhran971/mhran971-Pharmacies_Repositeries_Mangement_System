<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'pharmacy_id',
        'invoice_num',
        'costumer_fullName',
        'National_number',
        'user_id',
        'total_sum',
        'Psychiatric'

    ];

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
