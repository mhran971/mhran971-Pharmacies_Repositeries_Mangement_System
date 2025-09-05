<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    public $timestamps = false;
    protected $fillable = ['medicine_id', 'description'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
