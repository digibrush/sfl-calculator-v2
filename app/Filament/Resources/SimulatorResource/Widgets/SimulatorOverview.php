<?php

namespace App\Filament\Resources\SimulatorResource\Widgets;

use App\Models\Quote;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;

class SimulatorOverview extends BaseWidget
{
    public ?Model $record = null;

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 12;

    protected function getCards(): array
    {
        return [
            Card::make('Online Hours', $this->record->online_hours),
            Card::make('Offline Hours', $this->record->offline_hours),
//            Card::make('Online Cost', $this->record->online_cost),
//            Card::make('Offline Cost', $this->record->offline_cost),
            Card::make('Total Cost', $this->record->total_cost),
        ];
    }
}
