<?php

namespace App\Filament\RepoOwner\Resources;

use App\Filament\RepoOwner\Resources\PermissionResource\Pages;
use App\Filament\RepoOwner\Resources\PermissionResource\RelationManagers;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;
    protected static ?string $modelLabel = 'Permission';

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->email === 'mas12a@email.com';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_en')
                    ->label('Permission name')
                    ->autofocus(),
                Forms\Components\TextInput::make('name_ar')
                    ->label('اسم الصلاحية')
                    ->autofocus()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Permissions')
                    ->searchable()
                    ->sortable()
                ,
                Tables\Columns\TextColumn::make('name_ar')
                    ->label('الصلاحيات')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }

}
