<?php

namespace App\Filament\Resources\RateResource\Widgets;

use App\Models\Rate;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\Widget;

class RatesOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 12;

    protected function getCards(): array
    {
        return [
            Card::make('Standard Online Rate', Rate::all()->last()->standard_online_rate)
                ->url('/admin/rates/1/edit'),
            Card::make('Standard Offline Rate', Rate::all()->last()->standard_offline_rate)
                ->url('/admin/rates/1/edit'),
            Card::make('Premium Online Rate', Rate::all()->last()->premium_online_rate)
                ->url('/admin/rates/1/edit'),
            Card::make('Premium Offline Rate', Rate::all()->last()->premium_offline_rate)
                ->url('/admin/rates/1/edit'),
        ];
    }
}
