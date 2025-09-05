<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    public $timestamps = false;
    protected $fillable = ['medicine_id', 'alternative_medicine_id'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }

    public function alternativeMedicine(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Medicine::class, 'alternative_medicine_id');
    }
}
