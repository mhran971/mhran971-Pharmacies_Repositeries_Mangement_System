<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'medicine_id',
        'quantity',
        'batch',
        'purchase_price',
        'expiration_date',
        'total_price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function booted()
    {
        static::saved(function ($orderItem) {
            $order = $orderItem->order;
            $order->total_price = $order->items()->sum('total_price');
            $order->save();
        });

        static::deleted(function ($orderItem) {
            $order = $orderItem->order;
            $order->total_price = $order->items()->sum('total_price');
            $order->save();
        });
    }
}
