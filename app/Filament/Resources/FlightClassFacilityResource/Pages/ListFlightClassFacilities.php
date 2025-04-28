<?php

namespace App\Filament\Resources\FlightClassFacilityResource\Pages;

use App\Filament\Resources\FlightClassFacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlightClassFacilities extends ListRecords
{
    protected static string $resource = FlightClassFacilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
