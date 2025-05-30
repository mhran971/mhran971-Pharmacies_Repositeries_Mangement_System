<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $fillable = [
        'pharmacy_name',
        'pharmacy_phone',
        'pharmacy_address',
        'owner_id'
    ];


    public function pharmacists(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pharmacy_users');
    }
}
