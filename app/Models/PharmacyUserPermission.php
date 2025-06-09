<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PharmacyUserPermission extends Model
{
    protected $table = 'pharmacy_user_permissions';

    protected $fillable = [
        'permission_id',
        'pharmacy_User_id'
    ];
}
