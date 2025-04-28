<?php

namespace App\Filament\Resources\FlightSeatResource\Pages;

use App\Filament\Resources\FlightSeatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlightSeat extends EditRecord
{
    protected static string $resource = FlightSeatResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
