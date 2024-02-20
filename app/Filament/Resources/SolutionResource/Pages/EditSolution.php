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
        if ((isset($_GET['type']) && $_GET['type'] == "quote")) {
        	return [
                '/admin/quotes' => 'Quotes',
                '/admin/quotes/'.$this->record->product->quote->id.'/edit' => $this->record->product->quote->reference,
                '/admin/quotes/'.$this->record->product->quote->id.'/edit?activeRelationManager=0' => 'Products',
            	'/admin/products/'.$this->record->product->id.'/edit?type=quote' => $this->record->product->name,
                '/admin/products/'.$this->record->product->id.'/edit?type=quote&activeRelationManager=0' => 'Solutions',
            	'#' => $this->record->name,
        	];
        } elseif ((isset($_GET['type']) && $_GET['type'] == "simulation")) {
            return [
                '/admin/simulations' => 'Simulations',
                '/admin/simulations/'.$this->record->product->quote->id.'/edit' => $this->record->product->quote->id,
                '/admin/simulations/'.$this->record->product->quote->id.'/edit?activeRelationManager=0' => 'Products',
                '/admin/products/'.$this->record->product->id.'/edit?type=simulation' => $this->record->product->name,
                '/admin/products/'.$this->record->product->id.'/edit?type=simulation&activeRelationManager=0' => 'Solutions',
                '#' => $this->record->name,
            ];
        } else {
                return [
                    '/admin/products' => 'Products',
                    '/admin/products/'.$this->record->product->id.'/edit' => $this->record->product->name,
                    '/admin/products/'.$this->record->product->id.'/edit?activeRelationManager=0' => 'Solutions',
                    '#' => $this->record->name,
                ];
            }
        }
}
