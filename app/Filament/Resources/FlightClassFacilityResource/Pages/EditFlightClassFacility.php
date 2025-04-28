<?php

namespace App\Filament\Resources\FlightClassFacilityResource\Pages;

use App\Filament\Resources\FlightClassFacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlightClassFacility extends EditRecord
{
    protected static string $resource = FlightClassFacilityResource::class;

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
