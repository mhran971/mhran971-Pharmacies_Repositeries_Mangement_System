<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $table = 'verification_code';

    protected $fillable = [
        'email',
        'code',
    ];

}
