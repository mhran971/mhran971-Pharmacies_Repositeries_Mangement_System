<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository_User extends Model
{
    protected $table = 'repository_users';

    protected $fillable =[
        'repository_id',
        'user_id',
        'role',
        'active'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function repository(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Repository::class);
    }

    public function user_repo_permission(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Permission::class,
            'repository_user_permissions',
            'repository_user_id',
            'permission_id');
    }
}
