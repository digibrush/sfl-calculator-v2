<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back')
                ->hidden(fn(): bool => ($this->record->quote != null) ? true : false)
                ->color('secondary')
                ->url(url('/admin/products')),
            Actions\Action::make('back_quote')
                ->label('Back To Quote')
                ->hidden(fn(): bool => ($this->record->quote != null && $this->record->quote->type == "standard") ? false : true)
                ->color('secondary')
                ->url(url(($this->record->quote != null) ? '/admin/quotes/'.$this->record->quote->id.'/edit' : '')),
            Actions\Action::make('back_simulation')
                ->label('Back To Simulation')
                ->hidden(fn(): bool => ($this->record->quote != null && $this->record->quote->type == "simulation") ? false : true)
                ->color('secondary')
                ->url(url(($this->record->quote != null) ? '/admin/simulations/'.$this->record->quote->id.'/configurator' : '')),
            Actions\Action::make('back_template')
                ->label('Back To Template')
                ->hidden(fn(): bool => ($this->record->quote != null && $this->record->quote->type == "template") ? false : true)
                ->color('secondary')
                ->url(url(($this->record->quote != null) ? '/admin/templates/'.$this->record->quote->id.'/edit' : '')),
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
        return 'Product';
    }

    protected function getBreadcrumbs(): array
    {
        if ((isset($_GET['type']) && $_GET['type'] == "quote")) {
            return [
                '/admin/quotes/'.$this->record->quote->id.'/edit?type=quote&activeRelationManager=0' => 'Quotes',
                '/admin/products/'.$this->record->id.'/edit?type=quote' => $this->record->name,
            ];
        } else {
            return [
                '/admin/products' => 'Products',
                '/admin/products/'.$this->record->id.'/edit' => $this->record->name,
            ];
        }
    }
}
