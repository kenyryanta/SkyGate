<?php

namespace App\Filament\Resources\FlightClassResource\Pages;

use App\Filament\Resources\FlightClassResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlightClass extends EditRecord
{
    protected static string $resource = FlightClassResource::class;

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
