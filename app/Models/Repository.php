<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $fillable =[
        'repository_name',
        'repository_phone',
        'repository_address',
        'owner_id'
    ];
}
