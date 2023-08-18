<?php

namespace App\Filament\Resources\TermResource\Pages;

use App\Filament\Resources\TermResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTerm extends EditRecord
{
    protected static string $resource = TermResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
