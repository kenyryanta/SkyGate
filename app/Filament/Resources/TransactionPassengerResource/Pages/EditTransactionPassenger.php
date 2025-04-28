<?php

namespace App\Filament\Resources\TransactionPassengerResource\Pages;

use App\Filament\Resources\TransactionPassengerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionPassenger extends EditRecord
{
    protected static string $resource = TransactionPassengerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
