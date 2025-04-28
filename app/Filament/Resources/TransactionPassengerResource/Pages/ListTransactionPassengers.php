<?php

namespace App\Filament\Resources\TransactionPassengerResource\Pages;

use App\Filament\Resources\TransactionPassengerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionPassengers extends ListRecords
{
    protected static string $resource = TransactionPassengerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
