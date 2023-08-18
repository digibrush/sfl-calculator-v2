<?php

namespace App\Filament\Widgets;

use App\Models\Quote;
use Filament\Widgets\PieChartWidget;

class QuoteConversionPieChart extends PieChartWidget
{
    protected static ?string $heading = 'Quote Conversion';

    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'data' => [Quote::where('converted',false)->where('type','standard')->count(),Quote::where('converted',true)->where('type','standard')->count()],
                    'backgroundColor' => ['#36A2EB','#FF6384']
                ],
            ],
            'labels' => ['Unconverted', 'Converted'],
        ];
    }
}
