<?php

namespace App\Filament\RepoOwner\Resources;

use App\Filament\RepoOwner\Resources\MedicineResource\Pages;
use App\Filament\RepoOwner\Resources\MedicineResource\RelationManagers;
use App\Models\Medicine;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MedicineResource extends Resource
{
    protected static ?string $model = Medicine::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('trade_name')
                    ->label('Trade Name')
                    ->required()
                    ->maxLength(255),


                Select::make('laboratory_id')
                    ->label('Laboratory')
                    ->relationship('laboratory', 'laboratory_name')
                    ->searchable()
                    ->required(),

                TextInput::make('composition')
                    ->label('Composition')
                    ->required()
                    ->maxLength(255),

                TextInput::make('titer')
                    ->label('Titer')
                    ->required()
                    ->maxLength(255),

                TextInput::make('packaging')
                    ->label('Packaging')
                    ->required()
                    ->maxLength(255),

                Select::make('pharmaceutical_form_id')
                    ->label('Pharmaceutical Form')
                    ->relationship('pharmaceuticalForm', 'name')
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->paginated([10, 25, 50, 100,])->striped()->deferLoading()
            //->heading('Medicines')
            // ->description('Manage your Medicine here.')
            //->poll('1s')
            ->groups([
                'laboratory.name',
                'pharmaceuticalForm.name',
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('trade_name')->label('Trade Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('laboratory.name')->label('Laboratory Name')->sortable()->badge()->color('info'), Tables\Columns\TextColumn::make('composition')->label('Composition'),
                Tables\Columns\TextColumn::make('titer')->label('Titer')->badge(),
                Tables\Columns\TextColumn::make('packaging')->label('Packaging')->sortable()->badge()->color('success'),
                Tables\Columns\TextColumn::make('pharmaceuticalForm.name')->label('Pharmaceutical Form')->sortable()->badge()->color('warning'),])
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
            'index' => Pages\ListMedicines::route('/'),
            'create' => Pages\CreateMedicine::route('/create'),
            'edit' => Pages\EditMedicine::route('/{record}/edit'),
        ];
    }
}
