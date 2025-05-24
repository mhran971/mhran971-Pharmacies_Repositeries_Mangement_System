<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository_User extends Model
{
    protected $fillable =[
        'repository_id',
        'user_id',
        'role'
    ];
}
