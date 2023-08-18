<?php

namespace App\Filament\Resources\SimulatorResource\Pages;

use App\Filament\Resources\SimulatorResource;
use App\Models\Quote;
use Filament\Pages\Actions;
use Filament\Resources\Pages\Page;

class Configurator extends Page
{
    public function mount()
    {
        $this->record = Quote::findOrFail(request()->route('record'));
    }

    protected function getActions(): array
    {
        return [
            Actions\ButtonAction::make('select_all')
                ->label('Select All')
                ->color('primary')
                ->url(url('/simulator/simulations/'.$this->record->id.'/select-all')),
            Actions\ButtonAction::make('deselect_all')
                ->label('Deselect All')
                ->color('danger')
                ->url(url('/simulator/simulations/'.$this->record->id.'/deselect-all')),
            Actions\ButtonAction::make('back')
                ->label('Back')
                ->color('warning')
                ->url(url('/admin/simulations/'.$this->record->id.'/edit')),
        ];
    }

    protected static string $resource = SimulatorResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            SimulatorResource\Widgets\SimulatorOverview::class
        ];
    }

    protected static string $view = 'filament.resources.simulator-resource.pages.configurator';
}
