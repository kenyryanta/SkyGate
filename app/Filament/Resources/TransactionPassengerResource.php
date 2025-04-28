<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionPassengerResource\Pages;
use App\Filament\Resources\TransactionPassengerResource\RelationManagers;
use App\Models\TransactionPassenger;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionPassengerResource extends Resource
{
    protected static ?string $model = TransactionPassenger::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('transaction_id')->label('Transaction ID'),
                // Tables\Columns\TextColumn::make('flight_seat_id')->label('Seat ID'),
                Tables\Columns\TextColumn::make('seat.row')->label('Seat Row')->sortable(),
                Tables\Columns\TextColumn::make('seat.column')->label('Seat Column')->sortable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')->date(),
                Tables\Columns\TextColumn::make('nationality')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTransactionPassengers::route('/'),
            'create' => Pages\CreateTransactionPassenger::route('/create'),
            'edit' => Pages\EditTransactionPassenger::route('/{record}/edit'),
        ];
    }
}
