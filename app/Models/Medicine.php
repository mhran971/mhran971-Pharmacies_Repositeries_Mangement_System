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
        'code',
    ];
    public $timestamps = false;

    public function laboratory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(laboratory::class);
    }

    public function pharmaceuticalForm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pharmaceutical_Form::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function alternatives()
    {
        return $this->hasMany(Alternative::class, 'medicine_id');
    }

    public function alternativeFor()
    {
        return $this->hasMany(Alternative::class, 'alternative_medicine_id');
    }

    public function interactionsAsMedicine1()
    {
        return $this->hasMany(Interaction::class, 'medicine_id_1');
    }

    public function interactionsAsMedicine2()
    {
        return $this->hasMany(Interaction::class, 'medicine_id_2');
    }

}
