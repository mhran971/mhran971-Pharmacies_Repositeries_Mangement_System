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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\error;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

//    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
//    {
//        $user = Auth::user();
//
//        return parent::getEloquentQuery()
//            ->whereIn('status', ['pending', 'approved', 'rejected', 'delivered'])
//            ->when($user && $user->repoowner, function ($query) use ($user) {
//                $query->where('repository_id', $user->repoowner->id);
//            });
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->label('Id')->disabled(),

                TextInput::make('order_num')
                    ->label('Invoice num')
                    ->required(),

                Select::make('pharmacy_id')
                    ->options(fn() => cache()
                        ->remember('pharmacies', 3600, fn() => \App\Models\Pharmacy::pluck('pharmacy_name', 'id')))
                    ->label('Pharmacy name')
                    ->relationship('pharmacy', 'pharmacy_name')
                    ->preload()
                    ->disabled(),

                TextInput::make('pharmacy_address')
                    ->label('Pharmacy address')
                    ->disabled()
                    ->afterStateHydrated(fn($set, $record) => $set('pharmacy_address', $record->pharmacy?->pharmacy_address)),

                TextInput::make('pharmacy_phone')
                    ->label('Pharmacy phone')
                    ->disabled()
                    ->afterStateHydrated(fn($set, $record) => $set('pharmacy_phone', $record->pharmacy?->pharmacy_phone)),

                TextInput::make('pharmacy_owner')
                    ->label('Pharmacy owner')
                    ->disabled()
                    ->afterStateHydrated(fn($set, $record) => $set('pharmacy_owner', $record->pharmacy?->owner?->name)),

                Select::make('status')
                    ->label('Order status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'delivered' => 'Delivered',
                        'canceled' => 'Canceled',
                    ]),

                TextInput::make('total_price')
                    ->label('Total Price')
                    ->disabled(),

                Forms\Components\TextInput::make('paid')
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $paid = $state;
                        if ($paid > $get('total_price')) {
                            $paid = $get('total_price');
                        }
                        $set('paid', $paid);
                        $remaining = $get('total_price') - $paid;
                        $set('remaining', $remaining);
                    }),


                TextInput::make('remaining')->dehydrated(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Orders')
//             ->description('Manage your orders here.')
            ->poll('1s')

            ->groups([
                'pharmacy.pharmacy_name',
                'user.name',
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')->color(Color::Cyan)->alignLeft(),

                Tables\Columns\TextColumn::make('order_num')
                    ->sortable()
                    ->searchable()
                    ->alignLeft()
                    ->color(Color::Red),

                Tables\Columns\TextColumn::make('pharmacy.pharmacy_name')->alignLeft()->searchable(),
                Tables\Columns\TextColumn::make('pharmacy.pharmacy_address')->label('Pharmacy address')->alignLeft()->searchable(),
                Tables\Columns\TextColumn::make('pharmacy.pharmacy_phone')->label('Pharmacy phone')->alignLeft()->searchable(),
                Tables\Columns\TextColumn::make('pharmacy.owner.name')->label('Pharmacy Owner')->alignLeft()->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('From')->alignLeft()->searchable(),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'delivered' => 'Delivered',
                        'canceled' => 'Canceled',
                    ])
                    ->alignLeft()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_price')->money('usd')->color(Color::Cyan)->alignLeft(),

                Tables\Columns\TextInputColumn::make('paid')
                    ->beforeStateUpdated(function ($state, $record) {
                        if ($state > $record->total_price) {
                            $state = $record->total_price;
                        }
                        $record->remaining = $record->total_price - $state;
                        $record->paid = $state;
                    }),


                Tables\Columns\TextColumn::make('remaining')->badge('Sky'),
            ])->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'delivered' => 'Delivered',
                        'canceled' => 'Canceled',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->label('Content'),
                Tables\Actions\DeleteAction::make()->slideOver()->label('Delete'),
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
            ItemsRelationManager::class,
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
