<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('flight_id')->sortable()->searchable(),
                // Tables\Columns\TextColumn::make('flight_class_id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('flightClass.class_type')->label('Class Type')->sortable(),
                Tables\Columns\TextColumn::make('customer_id')
                ->label('Customer ID')
                ->sortable()
                ->searchable(),
                // ->formatStateUsing(fn ($state) => \App\Models\Customer::find($state)?->name ?? 'Tidak Diketahui'),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable(),
                Tables\Columns\TextColumn::make('phone')->sortable(),
                Tables\Columns\TextColumn::make('number_of_passengers')->sortable(),
                Tables\Columns\TextColumn::make('promo_code_id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->colors([
                        'pending' => 'warning',
                        'paid' => 'success',
                        'canceled' => 'danger',
                    ]),
                Tables\Columns\TextColumn::make('subtotal')->money('IDR'),
                Tables\Columns\TextColumn::make('grandtotal')->money('IDR'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'canceled' => 'Canceled',
                    ]),
                // Tables\Filters\TrashedFilter::make(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
