<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use App\Models\Request;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequest extends EditRecord
{
    protected static string $resource = RequestResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->label('Approve')
                ->color('success')
                ->hidden(($this->record->status != "pending"))
                ->url(route('request.approve', $this->record->id))
                ->button(),
            Actions\Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->hidden(($this->record->status != "pending"))
                ->url(route('request.reject', $this->record->id))
                ->button()
        ];
    }
}
