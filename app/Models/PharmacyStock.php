<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PharmacyStock extends Model
{
    protected $table = 'pharmacy_stocks';
    protected $fillable = [
        'medicine_id',
        'pharmacy_id',
        'quantity',
        'batch',
        'Purchase_price',
        'sale_price',
        'expiration_date',
    ];

    public function movements()
    {
        return $this->hasMany(Sales_movements::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }


}
