<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'trade_name',
        'laboratory_id',
        'composition',
        'titer',
        'packaging',
        'pharmaceutical_form_id',
    ];

    public function laboratory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function pharmaceuticalForm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pharmaceutical_Form::class);
    }
}
