<?php

namespace App\Filament\RepoOwner\Resources\RepositoryStockResource\Pages;

use App\Filament\RepoOwner\Resources\RepositoryStockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRepositoryStock extends EditRecord
{
    protected static string $resource = RepositoryStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
