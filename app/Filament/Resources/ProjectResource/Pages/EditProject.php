<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Models\Project;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back')
                ->hidden(fn(): bool => ($this->record->solution->product->quote != null) ? true : false)
                ->color('secondary')
                ->url(url('/admin/solutions/'.$this->record->solution->id.'/edit')),
            Actions\Action::make('back_quote')
                ->label('Back')
                ->hidden(fn(): bool => ($this->record->solution->product->quote != null && $this->record->solution->product->quote->type == "standard") ? false : true)
                ->color('secondary')
                ->url(url('/admin/solutions/'.$this->record->solution->id.'/edit?type=quote')),
            Actions\Action::make('back_simulation')
                ->label('Back To Simulation')
                ->hidden(fn(): bool => ($this->record->solution->product->quote != null && $this->record->solution->product->quote->type == "simulation") ? false : true)
                ->color('secondary')
                ->url(($this->record->solution->product->quote != null && $this->record->solution->product->quote->type == "simulation") ?? url('/admin/simulations/'.$this->record->solution->product->quote->id.'/configurator')),
            Actions\Action::make('back_template')
                ->label('Back')
                ->hidden(fn(): bool => ($this->record->solution->product->quote != null && $this->record->solution->product->quote->type == "template") ? false : true)
                ->color('secondary')
                ->url(url('/admin/solutions/'.$this->record->solution->id.'/edit?type=template')),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        if ($this->record->solution->product->quote != null) {
            if ($this->record->solution->product->quote->type == "standard") {
                return url('/admin/projects/'.$this->record->id.'/edit').'?type=quote';
            }
            if ($this->record->solution->product->quote->type == "simulation") {
                return url('/admin/projects/'.$this->record->id.'/edit').'?type=simulation';
            }
        }
        return url('/admin/projects/'.$this->record->id.'/edit');
    }

    protected function getBreadcrumbs(): array
    {
        return [
            '/admin/products' => 'Products',
            '/admin/products/'.$this->record->solution->product->id.'/edit?activeRelationManager=0' => $this->record->solution->product->name,
            '/admin/solutions/'.$this->record->solution->id.'/edit?activeRelationManager=0' => $this->record->solution->name,
            '/admin/projects/'.$this->record->id.'/edit' => $this->record->name,
        ];
    }
}
