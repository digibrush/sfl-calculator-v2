<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Rate;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        if ($product->type == 'quote' || $product->type == 'simulation' || $product->type == 'template') {
            $quote = $product->quote;

            $total_online_hours = $quote->products()->where('status', true)->sum('online_hours');
            $total_offline_hours = $quote->products()->where('status', true)->sum('offline_hours');

            $total_online_cost = $quote->products()->where('status', true)->sum('online_cost');
            $total_offline_cost = $quote->products()->where('status', true)->sum('offline_cost');

            $total_solutions = $quote->products()->where('status', true)->sum('solutions');
            $total_projects = $quote->products()->where('status', true)->sum('projects');

            $quote->update([
                'online_hours' => $total_online_hours,
                'offline_hours' => $total_offline_hours,
                'solutions' => $total_solutions,
                'projects' => $total_projects,
                'online_cost' => $total_online_cost,
                'offline_cost' => $total_offline_cost,
            ]);
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
