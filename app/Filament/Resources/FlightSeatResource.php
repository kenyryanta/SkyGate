<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlightSeatResource\Pages;
use App\Filament\Resources\FlightSeatResource\RelationManagers;
use App\Models\FlightSeat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FlightSeatResource extends Resource
{
    protected static ?string $model = FlightSeat::class;

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
                Forms\Components\TextInput::make('row')->required()->maxLength(5),
                Forms\Components\TextInput::make('column')->required()->maxLength(5),
                Forms\Components\Select::make('class_type')
                    ->options([
                        'economy' => 'Economy',
                        'business' => 'Business',
                        'first' => 'First'
                    ])->required(),
                Forms\Components\Toggle::make('is_available')
                    ->label('Available')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('flight.flight_number')->label('Flight Number')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('row')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('column')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('class_type')->sortable()->searchable(),
                Tables\Columns\IconColumn::make('is_available')->label('Available')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('flight_id')
                ->label('Flight Number')
                ->relationship('flight', 'flight_number'),
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
            'index' => Pages\ListFlightSeats::route('/'),
            'create' => Pages\CreateFlightSeat::route('/create'),
            'edit' => Pages\EditFlightSeat::route('/{record}/edit'),
        ];
    }
}
