<?php

namespace App\Filament\RepoOwner\Resources\MyEmployeesResource\Pages;

use App\Filament\RepoOwner\Resources\MyEmployeesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMyEmployees extends ListRecords
{
    protected static string $resource = MyEmployeesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
