<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Permission extends Model
{
    protected $table = 'permission';

    protected $fillable = [
        'name',

    ];

    public function permission_user_repo()
    {
        return $this->belongsToMany('repository_users');
    }
}
