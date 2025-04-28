<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoCodeResource\Pages;
use App\Filament\Resources\PromoCodeResource\RelationManagers;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromoCodeResource extends Resource
{
    protected static ?string $model = PromoCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->unique()
                    ->maxLength(255),

                Forms\Components\Select::make('discount_type')
                    ->options([
                        'fixed' => 'Fixed Amount',
                        'percentage' => 'Percentage',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('discount')
                    ->numeric()
                    ->required(),

                Forms\Components\DateTimePicker::make('valid_until')
                    ->required(),

                Forms\Components\Toggle::make('is_used')
                    ->label('Has been used?')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('discount_type')
                    ->label('Type')
                    ->sortable(),

                Tables\Columns\TextColumn::make('discount')
                    ->sortable()
                    ->formatStateUsing(fn ($record) =>
                        $record->discount_type === 'percentage'
                            ? $record->discount . '%'
                            : 'IDR ' . number_format($record->discount, 0, ',', '.')
                    ),


                Tables\Columns\TextColumn::make('valid_until')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_used')
                    ->boolean()
                    ->label('Used?'),
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
            'index' => Pages\ListPromoCodes::route('/'),
            'create' => Pages\CreatePromoCode::route('/create'),
            'edit' => Pages\EditPromoCode::route('/{record}/edit'),
        ];
    }
}
