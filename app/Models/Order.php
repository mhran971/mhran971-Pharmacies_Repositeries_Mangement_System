<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'pharmacy_id',
        'user_id',
        'repository_id',
        'order_num',
        'status',
        'total_price',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
