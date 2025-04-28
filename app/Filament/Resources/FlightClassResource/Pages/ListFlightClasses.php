<?php

namespace App\Filament\Resources\FlightClassResource\Pages;

use App\Filament\Resources\FlightClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlightClasses extends ListRecords
{
    protected static string $resource = FlightClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
