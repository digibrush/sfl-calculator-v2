<?php

namespace App\Filament\Widgets;

use App\Models\Quote;
use Carbon\Carbon;
use Filament\Widgets\LineChartWidget;

class QuoteRevenueLineChart extends LineChartWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 12;

    protected static ?string $maxHeight = '300px';

    protected function getHeading(): string
    {
        return 'Quote Financials';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Total Revenue',
                    'data' => $this->totalRevenueChart(),
                    'borderColor' => '#36A2EB',
                ],
                [
                    'label' => 'Total Income',
                    'data' => $this->totalIncomeChart(),
                    'borderColor' => '#FF6384',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    public function totalRevenueChart()
    {
        $data = array();
        for ($month = 1; $month <= 12; $month++) {
            $date = date('Y')."-".$month."-15";
            $start = Carbon::parse($date)->startOfMonth();
            $end = Carbon::parse($date)->endOfMonth();
            $monthlyTotal = Quote::whereBetween('created_at', [$start,$end])->where('type','standard')->sum('total_cost');
            array_push($data, $monthlyTotal);
        }
        return $data;
    }

    public function totalIncomeChart()
    {
        $data = array();
        for ($month = 1; $month <= 12; $month++) {
            $date = date('Y')."-".$month."-15";
            $start = Carbon::parse($date)->startOfMonth();
            $end = Carbon::parse($date)->endOfMonth();
            $monthlyTotal = Quote::where('converted', true)->whereBetween('created_at', [$start,$end])->where('type','standard')->sum('total_cost');
            array_push($data, $monthlyTotal);
        }
        return $data;
    }
}
