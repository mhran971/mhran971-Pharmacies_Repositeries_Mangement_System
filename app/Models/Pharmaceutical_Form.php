<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pharmaceutical_Form extends Model
{
    protected $table = 'pharmaceutical_forms';
    public $timestamps = false;
    protected $fillable = [
        'name_en',
        'name_ar',
        'image_path',
    ];

    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class, 'pharmaceutical_form_id');
    }
}
