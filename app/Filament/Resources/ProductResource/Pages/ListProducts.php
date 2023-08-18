<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ButtonAction::make('export')
                ->label('Export')
                ->url('/products/export')
                ->icon('heroicon-o-download')
                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}
