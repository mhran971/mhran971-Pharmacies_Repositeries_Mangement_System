<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class laboratory extends Model
{
    protected $table = 'laboratories';
    protected $fillable = [
        'name_en',
        'name_ar',
    ];
    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class, 'laboratory_id');
    }
}
