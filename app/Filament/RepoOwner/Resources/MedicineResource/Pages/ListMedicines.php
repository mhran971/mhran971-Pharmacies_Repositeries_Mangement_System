<?php

namespace App\Filament\RepoOwner\Resources\MedicineResource\Pages;

use App\Filament\RepoOwner\Resources\MedicineResource;
use App\Imports\MedicinesImport;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class ListMedicines extends ListRecords
{
    protected static string $resource = MedicineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('MedicinesImport')->label('UploadExcel')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->label('Upload Excel File')
                ->form([
                    FileUpload::make('attachment')
                ])->action(function (array $data) {
                    $path = Storage::disk('public')->path($data['attachment']);
                    //              dd($file);
                    Excel::import(new MedicinesImport, $path);

                    Notification::make()
                        ->title('Medicines Imported Successfully.')
                        ->success()
                        ->send();
                }),

        ];
    }
}
