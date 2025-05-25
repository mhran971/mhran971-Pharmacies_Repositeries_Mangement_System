<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository_User extends Model
{
    protected $table = 'repository_users';

    protected $fillable =[
        'repository_id',
        'user_id',
        'role'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function repository(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Repository::class);
    }

}
