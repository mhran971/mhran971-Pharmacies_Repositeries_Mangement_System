<?php

namespace App\Models;

use App\Jobs\UpdatePharmacyStockJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Queue\Queueable;

class StockMovement extends Model
{
    use Queueable;

    public $timestamps = false;

    protected $fillable = ['pharmacy_id', 'batch_id', 'type', 'qty', 'user_id'];

    protected static function booted(): void
    {
        static::created(function ($m) {
            UpdatePharmacyStockJob::dispatch($m);
        });
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

}
