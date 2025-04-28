<?php

namespace App\Filament\Resources\FlightSeatResource\Pages;

use App\Filament\Resources\FlightSeatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFlightSeat extends CreateRecord
{
    protected static string $resource = FlightSeatResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
