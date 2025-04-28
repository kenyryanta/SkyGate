<?php

namespace App\Filament\Resources\FlightClassFacilityResource\Pages;

use App\Filament\Resources\FlightClassFacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFlightClassFacility extends CreateRecord
{
    protected static string $resource = FlightClassFacilityResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
