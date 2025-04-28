<?php

namespace App\Filament\Resources\FlightClassResource\Pages;

use App\Filament\Resources\FlightClassResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFlightClass extends CreateRecord
{
    protected static string $resource = FlightClassResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
