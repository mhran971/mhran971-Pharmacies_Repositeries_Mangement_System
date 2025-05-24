<?php

namespace App\Filament\RepoOwner\Resources\UserResource\Pages;

use App\Filament\RepoOwner\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
