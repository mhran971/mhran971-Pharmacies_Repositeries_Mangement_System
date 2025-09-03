<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacy_name',
        'pharmacy_phone',
        'pharmacy_address',
        'owner_id'
    ];


    public function pharmacists(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pharmacy_users');
    }

    public function users()
    {
        return $this->hasMany(Pharmacy_User::class, 'pharmacy_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function stock()
    {
        return $this->hasMany(PharmacyStock::class);
    }

    public function pharmacy_stocks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'pharmacy_stocks');
    }
}
