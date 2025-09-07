<?php

namespace App\Models;

use App\Jobs\SendNotificationJob;
use App\Services\GeneralServices\NotificationService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'pharmacy_id',
        'user_id',
        'repository_id',
        'order_num',
        'status',
        'total_price',
        'paid',
        'remaining',
    ];

    protected static function booted()
    {

        static::saving(function ($order) {
            if ($order->paid > $order->total_price) {
                $order->paid = $order->total_price;
            }

            $order->remaining = $order->total_price - $order->paid;
        });

        static::updated(function ($order) {
            if ($order->wasChanged('status') && in_array($order->status, ['approved', 'rejected', 'delivered'])) {
                $notificationService = new NotificationService();
                $notificationService->send('fG9hNCPbTdmKyaEnStCuC0:APA91bHXkcYollGGOalt-SGqprEUqbG-SKIPE_bvikzOJ3JH1d4n_2_SGSHvwLUTjJhDOoOlhweTcNmu8Q4umoLTP7woAkWXfSkRsgqM3oIoLzzA58h4Z_8',
                    "Order #{$order->order_num} {$order->status}",
                    "Your order status changed to {$order->status}"
                );
            }


            if ($order->remaining > 0 && $order->updated_at < Carbon::now()->subDays(30)) {
                $notificationService = new NotificationService();
                $notificationService->send('fG9hNCPbTdmKyaEnStCuC0:APA91bHXkcYollGGOalt-SGqprEUqbG-SKIPE_bvikzOJ3JH1d4n_2_SGSHvwLUTjJhDOoOlhweTcNmu8Q4umoLTP7woAkWXfSkRsgqM3oIoLzzA58h4Z_8',
                    "Unpaid Order Reminder",
                    "Order #{$order->order_num} still has unpaid amount of {$order->remaining}"
                );
            }
        });
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
