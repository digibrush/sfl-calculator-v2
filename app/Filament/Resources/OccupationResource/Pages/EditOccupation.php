<?php

namespace App\Filament\Resources\OccupationResource\Pages;

use App\Filament\Resources\OccupationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOccupation extends EditRecord
{
    protected static string $resource = OccupationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
