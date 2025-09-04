<?php

namespace App\Filament\RepoOwner\Resources\OrderResource\Pages;

use App\Filament\RepoOwner\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
