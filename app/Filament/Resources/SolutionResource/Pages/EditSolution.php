<?php

namespace App\Filament\Resources\SolutionResource\Pages;

use App\Filament\Resources\SolutionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSolution extends EditRecord
{
    protected static string $resource = SolutionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back')
                ->hidden(fn(): bool => ($this->record->product->quote != null) ? true : false)
                ->color('secondary')
                ->url(url('/admin/products/'.$this->record->product->id.'/edit')),
            Actions\Action::make('back_quote')
                ->label('Back')
                ->hidden(fn(): bool => ($this->record->product->quote != null && $this->record->product->quote->type == "standard") ? false : true)
                ->color('secondary')
                ->url(url('/admin/products/'.$this->record->product->id.'/edit?type=quote')),
            Actions\Action::make('back_simulation')
                ->label('Back To Simulation')
                ->hidden(fn(): bool => ($this->record->product->quote != null && $this->record->product->quote->type == "simulation") ? false : true)
                ->color('secondary')
                ->url(url('/admin/simulations/'.$this->record->product->quote?->id.'/configurator')),
            Actions\Action::make('back_template')
                ->label('Back')
                ->hidden(fn(): bool => ($this->record->product->quote != null && $this->record->product->quote->type == "template") ? false : true)
                ->color('secondary')
                ->url(url('/admin/products/'.$this->record->product->id.'/edit?type=template')),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }

    public function getFormTabLabel(): ?string
    {
        return 'Solution';
    }

    protected function getBreadcrumbs(): array
    {
        return [
            '/admin/products' => 'Products',
            '/admin/products/'.$this->record->product->id.'/edit?activeRelationManager=0' => $this->record->product->name,
            '/admin/solutions/'.$this->record->id.'/edit' => $this->record->name,
        ];
    }
}
