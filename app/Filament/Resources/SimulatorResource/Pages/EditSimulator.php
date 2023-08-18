<?php

namespace App\Filament\Resources\SimulatorResource\Pages;

use App\Filament\Resources\SimulatorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSimulator extends EditRecord
{
    protected static string $resource = SimulatorResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            SimulatorResource\Widgets\SimulatorOverview::class
        ];
    }

    protected function getActions(): array
    {
        return [
            Actions\ButtonAction::make('configurator')
                ->label('Configurator')
                ->url(url('/admin/simulations/'.$this->record->id.'/configurator')),
            Actions\DeleteAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }

    public function getFormTabLabel(): ?string
    {
        return 'Summary';
    }
}
