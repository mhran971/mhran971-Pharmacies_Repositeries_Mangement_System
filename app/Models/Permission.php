<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'name_en',
        'name_ar',

    ];

    public function permission_user_repo()
    {
        return $this->belongsToMany('repository_users');
    }
}
