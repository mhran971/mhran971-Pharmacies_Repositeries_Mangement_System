<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\In;

class StockMovement extends Model
{
    protected $fillable = [
        'medicine_id',
        'pharmacy_id',
        'user_id',
        'quantity',
        'batch',
        'invoice_id'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
