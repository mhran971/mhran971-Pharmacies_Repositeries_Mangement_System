<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'trade_name',
        'laboratory_id',
        'composition',
        'titer',
        'packaging',
        'pharmaceutical_form_id',
    ];
    public $timestamps = false;

    public function laboratory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function pharmaceuticalForm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pharmaceutical_Form::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
