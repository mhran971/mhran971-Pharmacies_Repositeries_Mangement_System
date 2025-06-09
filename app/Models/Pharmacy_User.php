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
        'is_work'
    ];


    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function pharmacies(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function user_pharmacy_permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Permission::class,
            'pharmacy_user_permissions',
            'pharmacy_user_id',
            'permission_id');
    }
}
