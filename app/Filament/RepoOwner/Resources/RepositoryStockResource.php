<?php

namespace App\Filament\RepoOwner\Resources;

use App\Filament\RepoOwner\Resources\RepositoryStockResource\Pages;
use App\Filament\RepoOwner\Resources\RepositoryStockResource\RelationManagers;
use App\Models\RepositoryStock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RepositoryStockResource extends Resource
{
    protected static ?string $model = RepositoryStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Repository Stocks';
    protected static ?string $pluralLabel = 'Repository Stocks';
    protected static ?string $label = 'Repository Stock';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $user = Auth::user();

        return parent::getEloquentQuery()
//            ->whereIn('status', ['pending', 'approved', 'rejected', 'delivered'])
            ->when($user && $user->repoowner, function ($query) use ($user) {
                $query->where('repository_id', $user->repoowner->id);
            });
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('medicine_id')
                    ->relationship('medicine', 'name')
                    ->searchable()
                    ->required()
                    ->label('Medicine'),

                Forms\Components\Select::make('repository_id')
                    ->relationship('repository', 'name')
                    ->searchable()
                    ->required()
                    ->label('Repository'),

                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->label('Quantity'),

                Forms\Components\TextInput::make('batch')
                    ->maxLength(255)
                    ->label('Batch'),

                Forms\Components\TextInput::make('Purchase_price')
                    ->numeric()
                    ->required()
                    ->label('Purchase Price'),

                Forms\Components\TextInput::make('sale_price')
                    ->numeric()
                    ->required()
                    ->label('Sale Price'),

                Forms\Components\DatePicker::make('expiration_date')
                    ->label('Expiration Date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),

                Tables\Columns\TextColumn::make('medicine.name')
                    ->label('Medicine')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('repository.name')
                    ->label('Repository')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity'),

                Tables\Columns\TextColumn::make('batch')
                    ->label('Batch'),

                Tables\Columns\TextColumn::make('Purchase_price')
                    ->money('USD', true)
                    ->label('Purchase Price'),

                Tables\Columns\TextColumn::make('sale_price')
                    ->money('USD', true)
                    ->label('Sale Price'),

                Tables\Columns\TextColumn::make('expiration_date')
                    ->date('Y-m-d')
                    ->label('Expiration Date'),
            ])
            ->filters([
                Tables\Filters\Filter::make('expired')
                    ->label('Expired')
                    ->query(fn ($query) => $query->where('expiration_date', '<', now())),

                Tables\Filters\Filter::make('almost_expired')
                    ->label('Almost Expired (within 30 days)')
                    ->query(fn ($query) =>
                    $query->whereBetween('expiration_date', [now(), Carbon::now()->addDays(30)])
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepositoryStocks::route('/'),
            'create' => Pages\CreateRepositoryStock::route('/create'),
            'edit' => Pages\EditRepositoryStock::route('/{record}/edit'),
        ];
    }
}
