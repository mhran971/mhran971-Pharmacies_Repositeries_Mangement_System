<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicines';

    protected $fillable = [
        'trade_name',
        'laboratory_name',
        'composition',
        'titer',
        'packaging',
        'pharmaceutical_form',
    ];
}
