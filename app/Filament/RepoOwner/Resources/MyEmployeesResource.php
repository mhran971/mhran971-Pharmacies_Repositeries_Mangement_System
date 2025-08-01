<?php

namespace App\Filament\RepoOwner\Resources;

use App\Filament\RepoOwner\Resources\MyEmployeesResource\Pages;
use App\Filament\RepoOwner\Resources\MyEmployeesResource\RelationManagers;
use App\Filament\RepoOwner\Resources\PermissionsResource\RelationManagers\UserRepoPermissionRelationManager;
use App\Models\MyEmployees;
use App\Models\Repository_User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MyEmployeesResource extends Resource
{
    protected static ?string $model = Repository_User::class;
    protected static ?string $navigationLabel = 'My Employees';
    protected static ?string $modelLabel = 'My Employees';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getEloquentQuery(): Builder
    {
        $repository = auth()->user()?->repoowner()->first();

        return Repository_User::query()
            ->when($repository, fn($query) => $query->where('repository_id', $repository->id)
            )
            ->with('user');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Access Employee Name:')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->autofocus()->required(),

                Forms\Components\MultiSelect::make('user_repo_permission')
                    ->label('Permissions')
                    ->relationship('user_repo_permission', 'name_en')
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('role')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Employee Name')
                    ->searchable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'admin' => 'danger',
                        'editor' => 'success',
                        'viewer' => 'info',
                        default => 'primary',
                    })


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            UserRepoPermissionRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyEmployees::route('/'),
            'create' => Pages\CreateMyEmployees::route('/create'),
            'edit' => Pages\EditMyEmployees::route('/{record}/edit'),
        ];
    }
}
