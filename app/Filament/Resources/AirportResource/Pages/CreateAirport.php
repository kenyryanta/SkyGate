<?php

namespace App\Filament\Resources\AirportResource\Pages;

use App\Filament\Resources\AirportResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAirport extends CreateRecord
{
    protected static string $resource = AirportResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
