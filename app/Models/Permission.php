<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Permission extends Model
{
    protected $table = 'permissions';
    public $timestamps = false;
    protected $fillable = [
        'name_en',
        'name_ar',
    ];

    public function permission_user_repo(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Repository_User::class, 'repository_user_permissions', 'permission_id', 'repository_user_id');
    }

    public function repositoryUsers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Repository_User::class, 'repository_user_permissions', 'permission_id', 'repository_user_id');
    }
}
