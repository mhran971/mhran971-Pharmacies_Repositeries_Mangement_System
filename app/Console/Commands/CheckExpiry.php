<?php

namespace App\Console\Commands;

use App\Models\Batch;
use Illuminate\Console\Command;

class CheckExpiry extends Command
{

    protected $signature = 'inventory:check-expiry {--days=30}';
    protected $description = 'تنبيه عن دفعات الصلاحية القريبة';

    public function handle()
    {
        $days = $this->option('days');
        Batch::whereBetween('expiry_date', [now(), now()->addDays($days)])
            ->with('medicine')
            ->chunkById(100, fn($batches) => $batches->each(fn($b) => $this->info("Batch {$b->batch_no} of {$b->medicine->trade_name} expires {$b->expiry_date}")
            )
            );
        $this->info('Expiry check completed.');
    }
}
