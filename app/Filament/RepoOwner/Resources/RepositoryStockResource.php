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
use Illuminate\Support\Facades\Log;

class RepositoryStockResource extends Resource
{
    protected static ?string $model = RepositoryStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'My Stocks';
    protected static ?string $pluralLabel = 'My Stocks';
    protected static ?string $label = 'My Stock';
    protected static  $macros = 'My Stock';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $user = Auth::user();

        return parent::getEloquentQuery()
            ->when($user && $user->repoowner, function ($query) use ($user) {
                $query->where('repository_id', $user->repoowner->id);
            });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('medicine.trade_name')
                    ->relationship('medicine', 'trade_name')
                    ->searchable()
                    ->required()
                    ->label('Medicine'),

//                Forms\Components\Select::make('repository_id')
//                    ->relationship('repository', 'name')
//                    ->searchable()
//                    ->required()
//                    ->label('Repository'),

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
            ->striped()
            ->selectable()
            ->heading('My Stock')
//            ->description('Manage your Stock here.')
//            ->poll('1s')

            ->groups([
                'medicine.trade_name',
                'pharmacy.pharmacy_name',
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),

                Tables\Columns\TextColumn::make('medicine.trade_name')
                    ->label('Medicine')
                    ->badge('sky')
                    ->sortable()
                    ->searchable(),


                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity')->color('danger'),

                Tables\Columns\TextColumn::make('batch')
                    ->label('Batch')
                    ->sortable()
                    ->searchable(),

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
                Tables\Actions\ViewAction::make()->slideOver(),
                Tables\Actions\EditAction::make()->slideOver(),
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
