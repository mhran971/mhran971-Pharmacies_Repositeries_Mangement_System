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
//    public function user(): \Illuminate\Database\Eloquent\Relations\hasMany
//    {
//        return $this->hasMany(User::class, 'user_id');
//    }

//    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
//    {
//        return $this->belongsTo(User::class);
//    }

    public function pharmacyUsers()
    {
        return $this->hasMany(Pharmacy_User::class, 'user_id');
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
    public function permissions()
    {
        return $this->hasMany(PharmacyUserPermission::class, 'pharmacy_user_id');
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
