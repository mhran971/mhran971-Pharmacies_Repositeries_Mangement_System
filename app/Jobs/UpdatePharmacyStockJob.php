<?php

namespace App\Jobs;

use App\Models\StockMovement;
use App\Services\Pharmacy\Operations\PharmacyStockService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePharmacyStockJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    use InteractsWithQueue, Queueable, SerializesModels;

    private StockMovement $movement;

    public function __construct(StockMovement $movement)
    {
        $this->movement = $movement;
    }

    public function handle(PharmacyStockService $service)
    {
        $service->updateStock($this->movement);
    }
}
