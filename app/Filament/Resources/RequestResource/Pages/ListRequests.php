<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListRequests extends ListRecords
{
    protected static string $resource = RequestResource::class;

    protected function getActions(): array
    {
        return [
            //
        ];
    }
}
