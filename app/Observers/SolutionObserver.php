<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Solution;

class SolutionObserver
{
    /**
     * Handle the Solution "created" event.
     */
    public function created(Solution $solution): void
    {
        if ($solution->product != null) {
            $product = Product::findOrFail($solution->product->id);

            $total_online_hours = $product->solutions()->where('status', true)->sum('online_hours');
            $total_offline_hours = $product->solutions()->where('status', true)->sum('offline_hours');
            $total_online_cost = $product->solutions()->where('status', true)->sum('online_cost');
            $total_offline_cost = $product->solutions()->where('status', true)->sum('offline_cost');
            $total_projects = $product->solutions()->where('status', true)->sum('projects');
            $total_solutions = $product->solutions()->where('status', true)->count();

            $product->update([
                'online_hours' => $total_online_hours,
                'offline_hours' => $total_offline_hours,
                'online_cost' => $total_online_cost,
                'offline_cost' => $total_offline_cost,
                'projects' => $total_projects,
                'solutions' => $total_solutions
            ]);
        }
    }

    /**
     * Handle the Solution "updated" event.
     */
    public function updated(Solution $solution): void
    {
        $product = Product::findOrFail($solution->product->id);

        $total_online_hours = $product->solutions()->where('status', true)->sum('online_hours');
        $total_offline_hours = $product->solutions()->where('status', true)->sum('offline_hours');
        $total_online_cost = $product->solutions()->where('status', true)->sum('online_cost');
        $total_offline_cost = $product->solutions()->where('status', true)->sum('offline_cost');
        $total_projects = $product->solutions()->where('status', true)->sum('projects');
        $total_solutions = $product->solutions()->where('status', true)->count();

        $product->update([
            'online_hours' => $total_online_hours,
            'offline_hours' => $total_offline_hours,
            'online_cost' => $total_online_cost,
            'offline_cost' => $total_offline_cost,
            'projects' => $total_projects,
            'solutions' => $total_solutions
        ]);
    }

    /**
     * Handle the Solution "deleted" event.
     */
    public function deleted(Solution $solution): void
    {
        //
    }

    /**
     * Handle the Solution "restored" event.
     */
    public function restored(Solution $solution): void
    {
        //
    }

    /**
     * Handle the Solution "force deleted" event.
     */
    public function forceDeleted(Solution $solution): void
    {
        //
    }
}
