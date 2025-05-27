<?php

namespace App\Filament\RepoOwner\Resources\PermissionsResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class UserRepoPermissionRelationManager extends RelationManager
{
    protected static string $relationship = 'user_repo_permission';
    protected static ?string $model = \App\Models\Repository_User::class;
    protected static ?string $label = 'new employee permission';

    protected static ?string $title = "Employee's permission";

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('name_en')
                //     ->label('Permission Name (EN)')
                //     ->required()
                //     ->maxLength(255),
                //    Forms\Components\TextInput::make('name_ar')
                //        ->label('Permission Name (AR)')
                //        ->required()
                //        ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name_en')
            ->columns([
                Tables\Columns\TextColumn::make('name_en')->label('Name (EN)'),
                Tables\Columns\TextColumn::make('name_ar')->label('Name (AR)'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
