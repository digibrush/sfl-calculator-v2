<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Filament\Resources\QuoteResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListQuotes extends ListRecords
{
    protected static string $resource = QuoteResource::class;

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'reference';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getActions(): array
    {
        return [
            Actions\ButtonAction::make('calender')
                ->label('Calender')
                ->hidden(!Auth::user()->can('Access Calender Quotes'))
                ->url('/admin/quotes/calender')
                ->icon('heroicon-o-calendar')
                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}
