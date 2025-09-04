<?php

namespace App\Filament\RepoOwner\Resources;

use App\Filament\RepoOwner\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('Id')
                    ->disabled(),

                TextInput::make('order_num')
                    ->label('Invoice num')
                    ->required(),
                TextInput::make('total_price')
                    ->label('Total Price')
                    ,
//                    ->getStateUsing(fn($record) => $record->quantity * $record->purchase_price)
//                    ->summarize(fn ($records) => $records->sum(fn ($item) => $item->quantity * $item->purchase_price)),
                Select::make('pharmacy_id')
                    ->options(fn() => cache()
                        ->remember('pharmacies', 3600, fn() => \App\Models\Pharmacy::pluck('pharmacy_name', 'id')))
                    ->label('Pharmacy name')
                    ->relationship('pharmacy', 'pharmacy_name')
                    ->preload()
                    ->searchable()
                    ->disabled(),

                TextInput::make('pharmacy_address')
                    ->label('Pharmacy address')
                    ->disabled()
                    ->afterStateHydrated(fn($set, $record) => $set('pharmacy_address', $record->pharmacy?->pharmacy_address)
                    ),

                TextInput::make('pharmacy_phone')
                    ->label('Pharmacy phone')
                    ->disabled()
                    ->afterStateHydrated(fn($set, $record) => $set('pharmacy_phone', $record->pharmacy?->pharmacy_phone)
                    ),

                TextInput::make('pharmacy_owner')
                    ->label('Pharmacy owner')
                    ->disabled()
                    ->afterStateHydrated(fn($set, $record) => $set('pharmacy_owner', $record->pharmacy?->owner?->name)
                    ),

                select::make('status')
                    ->label('Order status')
                    ->options(['pending', 'approved', 'rejected', 'delivered', 'canceled']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->color(Color::Cyan)->alignLeft(),
                Tables\Columns\TextColumn::make('order_num')
                    ->sortable()
                    ->searchable()
                    ->alignLeft()
                    ->color(Color::Red)
                    ->bulleted('0')
                    ->alignLeft(),
                Tables\Columns\TextColumn::make('pharmacy.pharmacy_name')->alignLeft(),
                Tables\Columns\TextColumn::make('pharmacy.pharmacy_address')->label('Pharmacy address')->alignLeft(),
                Tables\Columns\TextColumn::make('pharmacy.pharmacy_phone')->label('Pharmacy phone')->alignLeft(),
                Tables\Columns\TextColumn::make('pharmacy.owner.name')->label('Pharmacy Owner')->alignLeft(),
                Tables\Columns\TextColumn::make('user.name')->label('From')->alignLeft(),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending'   => 'Pending',
                        'approved'  => 'Approved',
                        'rejected'  => 'Rejected',
                        'delivered' => 'Delivered',
                        'canceled'  => 'Canceled',
                    ])
                    ->alignLeft(),



                Tables\Columns\TextColumn::make('total_price') ->money('usd')->color(Color::Cyan)->alignLeft(),
            ])
            ->filters([
        //
    ])
        ->actions([
            Tables\Actions\EditAction::make()->slideOver(),
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
            ItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
