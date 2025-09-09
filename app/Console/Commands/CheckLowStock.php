<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PharmacyStock;
use App\Services\GeneralServices\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckLowStock extends Command
{
    protected $signature = 'stock:check-low';
    protected $description = 'Check pharmacy stock and send notifications if quantity is low';

    public function handle(): void
    {
        $now = Carbon::now();
        $notificationService = new NotificationService();

        $stocks = PharmacyStock::with(['pharmacy.owner', 'medicine'])
            ->where('quantity', '<', 5)
            ->get();

        foreach ($stocks as $stock) {
            $ownerName = $stock->pharmacy?->owner?->name;
            $medicineName = $stock->medicine?->trade_name ?? $stock->medicine?->name ?? 'Unknown Medicine';

            if (!$ownerName) {
                Log::warning("Stock ID {$stock->id} has no pharmacy owner. Notification skipped.");
                continue;
            }

            // تحقق من آخر إشعار (كل 24 ساعة)
            if (1) {
                $notificationService->send(
                    'cmpQaOwTR9-_ssTSsK7vG5:APA91bEsPUfxur90meuOHXzLNNtVuVljPtVC_YH6l3L1PHcTPGmsUxAkoPGS_Y9KwZz6csNLIldTUGUdiwELZYGLFRtD1Lm8OageQb8aqDz9gCDP_GcjLKk',
                    "{$ownerName} be attention to your Stock",
                    "You don’t have {$medicineName} in your stock, just [{$stock->quantity}] left!"

                );



                Log::info("Low stock notification sent for {$medicineName} to {$ownerName}");
            } else {
                Log::info("Stock ID {$stock->id} already notified within 24 hours.");
            }
        }
    }
}
