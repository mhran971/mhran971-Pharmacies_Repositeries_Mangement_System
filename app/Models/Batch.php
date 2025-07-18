<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = ['medicine_id', 'batch_no', 'expiry_date', 'initial_qty'];
    protected $casts = ['expiry_date' => 'date'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
