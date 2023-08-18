<?php

namespace App\Filament\Resources\SimulatorResource\Pages;

use App\Filament\Resources\SimulatorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSimulators extends ListRecords
{
    protected static string $resource = SimulatorResource::class;

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
