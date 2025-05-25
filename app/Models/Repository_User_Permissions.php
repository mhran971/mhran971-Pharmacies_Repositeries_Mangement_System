<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository_User_Permissions extends Model
{
    protected $table = 'repository_user_permissions';

    protected $fillable = [
        'permission_id',
        'Repository_User_id'
    ];
}
