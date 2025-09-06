<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    public $timestamps = false;
    protected $fillable = ['medicine_id_1', 'medicine_id_2'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
