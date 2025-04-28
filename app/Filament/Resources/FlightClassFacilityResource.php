<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlightClassFacilityResource\Pages;
use App\Filament\Resources\FlightClassFacilityResource\RelationManagers;
use App\Models\FlightClassFacility;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FlightClassFacilityResource extends Resource
{
    protected static ?string $model = FlightClassFacility::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            // ->schema([
            //     Forms\Components\Select::make('flight_class_id')
            //         ->relationship('flightClass', 'class_type')
            //         ->preload()
            //         ->searchable()
            //         ->required(),
            //     Forms\Components\Select::make('facility_id')
            //         ->relationship('facility', 'name')
            //         ->preload()
            //         ->searchable()
            //         ->required(),
            // ]);
            ->schema([
                // Pilih Flight Number terlebih dahulu
                Forms\Components\Select::make('flight_id')
                    ->label('Flight Number')
                    ->relationship('flight', 'flight_number')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->reactive() // Agar bisa memicu update pada field lain
                    ->afterStateUpdated(function ($set) {
                        // Reset flight_class_id dan facility_id saat flight berubah
                        $set('flight_class_id', null);
                        $set('facility_id', null);
                    }),

                // Pilih Class Type berdasarkan Flight yang dipilih
                Forms\Components\Select::make('flight_class_id')
                    ->label('Class Type')
                    ->options(function (callable $get) {
                        $flightId = $get('flight_id');
                        if ($flightId) {
                            return \App\Models\FlightClass::where('flight_id', $flightId)
                                ->pluck('class_type', 'id');
                        }
                        return [];
                    })
                    ->preload()
                    ->searchable()
                    ->required(),

                // Pilih Facility yang tersedia
                Forms\Components\Select::make('facility_id')
                    ->label('Facility')
                    ->relationship('facility', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('flightClass.class_type')->label('Class Type')->sortable()->searchable(),
                // Tables\Columns\TextColumn::make('facility.name')->label('Facility')->sortable()->searchable(),
                // Menampilkan Flight Number
                Tables\Columns\TextColumn::make('flight.flight_number')
                ->label('Flight Number')
                ->searchable()
                ->sortable(),

                // Menampilkan Class Type
                Tables\Columns\TextColumn::make('flightClass.class_type')
                    ->label('Class Type')
                    ->searchable()
                    ->sortable(),

                // Menampilkan Facility Name
                Tables\Columns\TextColumn::make('facility.name')
                    ->label('Facility')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                // Filter berdasarkan Flight Number
                Tables\Filters\SelectFilter::make('flight_id')
                ->label('Flight Number')
                ->relationship('flight', 'flight_number'),

                // Filter berdasarkan Class Type
                Tables\Filters\SelectFilter::make('flight_class_id')
                    ->label('Class Type')
                    ->relationship('flightClass', 'class_type'),

                // Filter berdasarkan Facility Name
                Tables\Filters\SelectFilter::make('facility_id')
                    ->label('Facility')
                    ->relationship('facility', 'name'),
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
            'index' => Pages\ListFlightClassFacilities::route('/'),
            'create' => Pages\CreateFlightClassFacility::route('/create'),
            'edit' => Pages\EditFlightClassFacility::route('/{record}/edit'),
        ];
    }
}
