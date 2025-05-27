<?php

namespace App\Filament\RepoOwner\Resources\MyEmployeesResource\Pages;

use App\Filament\RepoOwner\Resources\MyEmployeesResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMyEmployees extends CreateRecord
{
    protected static string $resource = MyEmployeesResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $repository = Auth::user()?->owner()->first();
        if ($repository) {
            $data['repository_id'] = $repository->id;

        }
        return $data;
    }

}
