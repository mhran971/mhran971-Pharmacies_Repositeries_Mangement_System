<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    public $timestamps = false;
    protected $fillable = ['medicine_id_1', 'medicine_id_2'];

    public function medicine1()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id_1');
    }

    public function medicine2()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id_2');
    }
}
