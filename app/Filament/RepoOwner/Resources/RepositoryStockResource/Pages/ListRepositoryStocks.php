<?php

namespace App\Filament\RepoOwner\Resources\RepositoryStockResource\Pages;

use App\Filament\RepoOwner\Resources\RepositoryStockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRepositoryStocks extends ListRecords
{
    protected static string $resource = RepositoryStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
