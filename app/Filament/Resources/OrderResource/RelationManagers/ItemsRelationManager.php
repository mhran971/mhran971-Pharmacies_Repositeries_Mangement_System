<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('medicine_id')
                    ->label('Medicine')
                    ->relationship('medicine', 'trade_name')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->required()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $set('total_price', $state * $get('purchase_price'));
                    }),

                Forms\Components\TextInput::make('purchase_price')
                    ->label('Purchase Price')
                    ->numeric()
                    ->required()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $set('total_price', $state * $get('quantity'));
                    }),


                Forms\Components\TextInput::make('batch'),


                Forms\Components\DatePicker::make('expiration_date')
                    ->label('Expiration Date')
                    ->required(),
//
//                Forms\Components\TextInput::make('total_price')
//                    ->label('Total Price')
//                    ->disabled()
//                    ->dehydrated(false),
//                Forms\Components\TextInput::make('paid'),
//                Forms\Components\TextInput::make('remaining')
//                    ->afterStateUpdated(function ($state, $set, $get) {
//                    $set('remaining', $state - $get('paid'));
//                }),
                TextInput::make('total_price')
                    ->label('Total Price')

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),

                Tables\Columns\TextColumn::make('medicine.trade_name')
                    ->label('Medicine'),

                Tables\Columns\TextInputColumn::make('quantity')
                    ->label('Quantity')
//                    ->numeric()
                    ->afterStateUpdated(function ($state, $record) {
                        $record->update([
                            'total_price' => $state * $record->purchase_price,
                        ]);
                    }),

                Tables\Columns\TextInputColumn::make('purchase_price')
                    ->label('Purchase Price')
                    ->rules(['numeric'])
                    ->state(fn ($record) => $record->purchase_price) // مهم جداً حتى تبقى القيمة
                    ->afterStateUpdated(function ($state, $record) {
                        $record->update([
                            'purchase_price' => $state,
                            'total_price'    => $state * $record->quantity,
                        ]);
                    }),




                Tables\Columns\TextColumn::make('batch')
                    ->label('Batch'),

                Tables\Columns\TextColumn::make('expiration_date')
                    ->label('Expiration Date')
                    ->date('Y-m-d'),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Price')->disabled(),

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record) {
                        $record->order->update([
                            'total_price' => $record->order->items->sum(fn($item) => $item->quantity * $item->purchase_price)
                        ]);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()
                    ->after(function ($record) {
                        $record->order->update([
                            'total_price' => $record->order->items->sum(fn($item) => $item->quantity * $item->purchase_price)
                        ]);
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function ($record) {
                        $record->order->update([
                            'total_price' => $record->order->items->sum(fn($item) => $item->quantity * $item->purchase_price)
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function ($records) {
                            $records->first()?->order->update([
                                'total_price' => $records->first()->order->items->sum(fn($item) => $item->quantity * $item->purchase_price)
                            ]);
                        }),
                ]),
            ]);
    }
}
