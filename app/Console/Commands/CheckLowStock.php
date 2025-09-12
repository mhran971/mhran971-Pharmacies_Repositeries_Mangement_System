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

        $notificationService = new NotificationService();

         $stocks = PharmacyStock::with(['pharmacy.owner', 'medicine'])
            ->where('quantity', '<', 5)
            ->get();

         $ownersStocks = [];

        foreach ($stocks as $stock) {
            $ownerName = $stock->pharmacy?->owner?->name ?? 'Owner';
            $ownerToken = $stock->pharmacy?->owner?->fcm_token ?? null; // إذا عندك FCM Token لكل مالك
            $medicineName = $stock->medicine?->trade_name ?? $stock->medicine?->name ?? 'Unknown Medicine';
            $quantity = $stock->quantity;

            if (!$ownerToken) {
                continue;
            }

            $ownersStocks[$ownerToken]['owner_name'] = $ownerName;
            $ownersStocks[$ownerToken]['medicines'][] = [
                'trade_name' => $medicineName,
                'quantity' => $quantity,
            ];
        }


        foreach ($ownersStocks as $token => $data) {
            $medicineList = '';
            foreach ($data['medicines'] as $med) {
                $medicineList .= "{$med['trade_name']} [{$med['quantity']}], ";
            }
            $medicineList = rtrim($medicineList, ', ');

            $notificationService->send(
                $token,
                "{$data['owner_name']}, be attention to your Stock",
                "Low stock for: {$medicineList}"
            );
        }





    }
}
