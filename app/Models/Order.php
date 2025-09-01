<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'pharmacy_id',
        'repository_id',
        'status',
        'total_price',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
