<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlightClassResource\Pages;
use App\Filament\Resources\FlightClassResource\RelationManagers;
use App\Models\FlightClass;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FlightClassResource extends Resource
{
    protected static ?string $model = FlightClass::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('flight_id')
                    ->relationship('flight', 'flight_number')
                    ->preload()  // Menampilkan 5 data terlebih dahulu
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('class_type')
                    ->options([
                        'economy' => 'Economy',
                        'business' => 'Business',
                        'first' => 'First'
                    ])->required(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('total_seats')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('flight.flight_number')->label('Flight Number')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('class_type')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('price')->money('IDR', true)->sortable()->searchable(),
                Tables\Columns\TextColumn::make('total_seats')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListFlightClasses::route('/'),
            'create' => Pages\CreateFlightClass::route('/create'),
            'edit' => Pages\EditFlightClass::route('/{record}/edit'),
        ];
    }
}
