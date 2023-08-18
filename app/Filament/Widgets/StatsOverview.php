<?php

namespace App\Filament\Widgets;

use App\Models\Company;
use App\Models\Quote;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 12;

    protected function getCards(): array
    {
        return [
            Card::make('Companies', Company::all()->count())
                ->description($this->companiesAnalytics()['description'])
                ->descriptionIcon($this->companiesAnalytics()['descriptionIcon'])
                ->chart($this->companiesAnalytics()['chart'])
                ->color($this->companiesAnalytics()['color']),
            Card::make('Clients', User::where('type', 'client')->count())
                ->description($this->clientsAnalytics()['description'])
                ->descriptionIcon($this->clientsAnalytics()['descriptionIcon'])
                ->chart($this->clientsAnalytics()['chart'])
                ->color($this->clientsAnalytics()['color']),
            Card::make('Total Revenue', number_format(Quote::all()->where('type','standard')->sum('total_cost'), 2))
                ->description($this->revenueAnalytics()['description'])
                ->descriptionIcon($this->revenueAnalytics()['descriptionIcon'])
                ->chart($this->revenueAnalytics()['chart'])
                ->color($this->revenueAnalytics()['color']),
            Card::make('Total Income', number_format(Quote::where('converted', true)->where('type','standard')->get()->sum('total_cost'), 2))
                ->description($this->incomeAnalytics()['description'])
                ->descriptionIcon($this->incomeAnalytics()['descriptionIcon'])
                ->chart($this->incomeAnalytics()['chart'])
                ->color($this->incomeAnalytics()['color']),
        ];
    }

    public function companiesAnalytics()
    {
        $chart = Company::select(
            DB::raw('count(id) as `count`'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date")
        )->groupBy('date')->orderBy('date')->get()->pluck('count')->toArray();
        $last30DaysCount = Company::whereBetween('created_at', [now()->subMonths(1),now()])->count();
        $previous30DaysCount = Company::whereBetween('created_at', [now()->subMonths(2),now()->subMonths(1)])->count();
        $difference = $last30DaysCount - $previous30DaysCount;
        if ($difference < 0) {
            $description = abs($difference)." decrease";
            $descriptionIcon = "heroicon-s-trending-down";
            $color = "danger";
        } else {
            $description = abs($difference)." increase";
            $descriptionIcon = "heroicon-s-trending-up";
            $color = "success";
        }
        return [
            'description' => $description,
            'descriptionIcon' => $descriptionIcon,
            'chart' => $chart,
            'color' => $color,
        ];
    }

    public function clientsAnalytics()
    {
        $chart = User::select(
            DB::raw('count(id) as `count`'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date")
        )->where('type', 'client')->groupBy('date')->orderBy('date')->get()->pluck('count')->toArray();
        $last30DaysCount = User::where('type', 'client')->whereBetween('created_at', [now()->subMonths(1),now()])->count();
        $previous30DaysCount = User::where('type', 'client')->whereBetween('created_at', [now()->subMonths(2),now()->subMonths(1)])->count();
        $difference = $last30DaysCount - $previous30DaysCount;
        if ($difference < 0) {
            $description = abs($difference)." decrease";
            $descriptionIcon = "heroicon-s-trending-down";
            $color = "danger";
        } else {
            $description = abs($difference)." increase";
            $descriptionIcon = "heroicon-s-trending-up";
            $color = "success";
        }
        return [
            'description' => $description,
            'descriptionIcon' => $descriptionIcon,
            'chart' => $chart,
            'color' => $color,
        ];
    }

    public function revenueAnalytics()
    {
        $chart = Quote::select(
            DB::raw('sum(total_cost) as `sum`'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date")
        )->where('type','standard')->groupBy('date')->orderBy('date')->get()->pluck('sum')->toArray();
        $last30DaysCount = Quote::whereBetween('created_at', [now()->subMonths(1),now()])->where('type','standard')->sum('total_cost');
        $previous30DaysCount = Quote::whereBetween('created_at', [now()->subMonths(2),now()->subMonths(1)])->where('type','standard')->sum('total_cost');
        $difference = $last30DaysCount - $previous30DaysCount;
        if ($difference < 0) {
            $description = $this->number_shorten(abs($difference), 0)." decrease";
            $descriptionIcon = "heroicon-s-trending-down";
            $color = "danger";
        } else {
            $description = $this->number_shorten(abs($difference), 0)." increase";
            $descriptionIcon = "heroicon-s-trending-up";
            $color = "success";
        }
        return [
            'description' => $description,
            'descriptionIcon' => $descriptionIcon,
            'chart' => $chart,
            'color' => $color,
        ];
    }

    public function incomeAnalytics()
    {
        $chart = Quote::select(
            DB::raw('sum(total_cost) as `sum`'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date")
        )->where('type','standard')->where('converted', true)->groupBy('date')->orderBy('date')->get()->pluck('sum')->toArray();
        $last30DaysCount = Quote::where('converted', true)->whereBetween('created_at', [now()->subMonths(1),now()])->where('type','standard')->sum('total_cost');
        $previous30DaysCount = Quote::where('converted', true)->whereBetween('created_at', [now()->subMonths(2),now()->subMonths(1)])->where('type','standard')->sum('total_cost');
        $difference = $last30DaysCount - $previous30DaysCount;
        if ($difference < 0) {
            $description = $this->number_shorten(abs($difference), 0)." decrease";
            $descriptionIcon = "heroicon-s-trending-down";
            $color = "danger";
        } else {
            $description = $this->number_shorten(abs($difference), 0)." increase";
            $descriptionIcon = "heroicon-s-trending-up";
            $color = "success";
        }
        return [
            'description' => $description,
            'descriptionIcon' => $descriptionIcon,
            'chart' => $chart,
            'color' => $color,
        ];
    }

    // Shortens a number and attaches K, M, B, etc. accordingly
    public function number_shorten($number, $precision = 3, $divisors = null)
    {

        // Setup default $divisors if not provided
        if (!isset($divisors)) {
            $divisors = array(
                pow(1000, 0) => '', // 1000^0 == 1
                pow(1000, 1) => 'K', // Thousand
                pow(1000, 2) => 'M', // Million
                pow(1000, 3) => 'B', // Billion
                pow(1000, 4) => 'T', // Trillion
                pow(1000, 5) => 'Qa', // Quadrillion
                pow(1000, 6) => 'Qi', // Quintillion
            );
        }

        // Loop through each $divisor and find the
        // lowest amount that matches
        foreach ($divisors as $divisor => $shorthand) {
            if (abs($number) < ($divisor * 1000)) {
                // We found a match!
                break;
            }
        }

        // We found our match, or there were no matches.
        // Either way, use the last defined value for $divisor.
        return number_format($number / $divisor, $precision) . $shorthand;
    }
}
