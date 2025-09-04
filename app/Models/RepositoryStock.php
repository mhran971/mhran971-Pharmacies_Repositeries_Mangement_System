<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepositoryStock extends Model
{
    protected $table = 'repository_stocks';

    protected $fillable = [
        'medicine_id',
        'repository_id',
        'quantity',
        'batch',
        'Purchase_price',
        'sale_price',
        'expiration_date',
    ];


    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }




}
