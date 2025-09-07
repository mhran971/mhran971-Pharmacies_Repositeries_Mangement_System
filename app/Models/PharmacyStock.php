<?php

namespace App\Models;

use App\Jobs\SendNotificationJob;
use App\Services\GeneralServices\NotificationService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PharmacyStock extends Model
{
    protected $table = 'pharmacy_stocks';
    protected $fillable = [
        'medicine_id',
        'pharmacy_id',
        'quantity',
        'batch',
        'Purchase_price',
        'sale_price',
        'expiration_date',
        'last_low_stock_notification_at',
        'last_expired_notification_at',
    ];

    protected static function booted()
    {
        static::saved(function ($stock) {
            $now = Carbon::now();

            // Low stock alert
            if ($stock->quantity < 5) {
                if (!$stock->last_low_stock_notification_at || $now->diffInHours($stock->last_low_stock_notification_at) >= 24) {
                    try {
                        $notificationService = new NotificationService();
                        $notificationService->send(
                            'fG9hNCPbTdmKyaEnStCuC0:APA91bHXkcYollGGOalt-SGqprEUqbG-SKIPE_bvikzOJ3JH1d4n_2_SGSHvwLUTjJhDOoOlhweTcNmu8Q4umoLTP7woAkWXfSkRsgqM3oIoLzzA58h4Z_8',
                            "Low Stock Alert",
                            "The medicine {$stock->medicine->name} is low in stock (only {$stock->quantity} left)."
                        );

                        $stock->last_low_stock_notification_at = $now;
                        $stock->saveQuietly();

                        \Log::info("✅ Low stock notification sent for {$stock->medicine->name}");
                    } catch (\Exception $e) {
                        \Log::error("❌ Low stock notification failed: " . $e->getMessage());
                    }
                }
            }

            // Expired medicine alert
            if ($stock->expiration_date && Carbon::parse($stock->expiration_date)->isPast()) {
                if (!$stock->last_expired_notification_at || $now->diffInHours($stock->last_expired_notification_at) >= 24) {
                    try {
                        $notificationService = new NotificationService();
                        $notificationService->send(
                            'fG9hNCPbTdmKyaEnStCuC0:APA91bHXkcYollGGOalt-SGqprEUqbG-SKIPE_bvikzOJ3JH1d4n_2_SGSHvwLUTjJhDOoOlhweTcNmu8Q4umoLTP7woAkWXfSkRsgqM3oIoLzzA58h4Z_8',
                            "Expired Medicine Alert",
                            "The medicine {$stock->medicine->name} has expired on {$stock->expiration_date}."
                        );

                        $stock->last_expired_notification_at = $now;
                        $stock->saveQuietly();

                        \Log::info("✅ Expired medicine notification sent for {$stock->medicine->name}");
                    } catch (\Exception $e) {
                        \Log::error("❌ Expired medicine notification failed: " . $e->getMessage());
                    }
                }
            }
        });
    }


    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
