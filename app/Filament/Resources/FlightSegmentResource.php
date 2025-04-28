<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlightSegmentResource\Pages;
use App\Filament\Resources\FlightSegmentResource\RelationManagers;
use App\Models\FlightSegment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FlightSegmentResource extends Resource
{
    protected static ?string $model = FlightSegment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sequence')->required()->numeric(),
                Forms\Components\Select::make('flight_id')
                    ->relationship('flight', 'flight_number')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('airport_id')
                    ->relationship('airport', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\DateTimePicker::make('time')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sequence')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('flight.flight_number')->label('Flight Number')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('airport.name')->label('Airport')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('time')->sortable(),
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
            'index' => Pages\ListFlightSegments::route('/'),
            'create' => Pages\CreateFlightSegment::route('/create'),
            'edit' => Pages\EditFlightSegment::route('/{record}/edit'),
        ];
    }
}
