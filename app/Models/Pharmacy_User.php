<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmacy_User extends Model
{
    protected $table = 'pharmacy_users';

    protected $fillable = [
        'pharmacy_id',
        'user_id',
        'role',
        'active'
    ];


    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function pharmacies(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
