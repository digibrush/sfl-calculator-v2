<?php

namespace App\Filament\Resources\SectorResource\Pages;

use App\Filament\Resources\SectorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSectors extends ListRecords
{
    protected static string $resource = SectorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
