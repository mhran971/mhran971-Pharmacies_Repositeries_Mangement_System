<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
//    protected $table = 'roles';
    protected $fillable =
        [
            'name'
        ];
    public $timestamps = false;
    public function owner(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
