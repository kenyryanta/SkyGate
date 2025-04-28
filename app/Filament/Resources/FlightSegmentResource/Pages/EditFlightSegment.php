<?php

namespace App\Filament\Resources\FlightSegmentResource\Pages;

use App\Filament\Resources\FlightSegmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlightSegment extends EditRecord
{
    protected static string $resource = FlightSegmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
