<?php

namespace App\Filament\Resources\FlightSegmentResource\Pages;

use App\Filament\Resources\FlightSegmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFlightSegment extends CreateRecord
{
    protected static string $resource = FlightSegmentResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
