<?php

namespace App\Filament\Widgets;

use App\Models\Quote;
use Carbon\Carbon;
use Filament\Widgets\LineChartWidget;

class QuoteQuantityLineChart extends LineChartWidget
{
    protected static ?string $heading = 'Quote Volume';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 11;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Total Quotes',
                    'data' => $this->totalRevenueChart(),
                    'borderColor' => '#36A2EB',
                ],
                [
                    'label' => 'Converted Quotes',
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
            $monthlyTotal = Quote::whereBetween('created_at', [$start,$end])->where('type','standard')->count();
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
            $monthlyTotal = Quote::where('converted', true)->whereBetween('created_at', [$start,$end])->where('type','standard')->count();
            array_push($data, $monthlyTotal);
        }
        return $data;
    }
}
