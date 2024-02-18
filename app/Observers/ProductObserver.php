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

            $total_hours = $quote->products()->where('status', true)->sum('hours');

            $total_cost = $quote->products()->where('status', true)->sum('cost');

            $total_solutions = $quote->products()->where('status', true)->sum('solutions');
            $total_projects = $quote->products()->where('status', true)->sum('projects');

            $quote->update([
                'hours' => $total_hours,
                'solutions' => $total_solutions,
                'projects' => $total_projects,
                'cost' => $total_cost,
            ]);
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        if ($product->type == 'quote' || $product->type == 'simulation' || $product->type == 'template') {
            $quote = $product->quote;

            $total_hours = $quote->products()->where('status', true)->sum('hours');

            $total_cost = $quote->products()->where('status', true)->sum('cost');

            $total_solutions = $quote->products()->where('status', true)->sum('solutions');
            $total_projects = $quote->products()->where('status', true)->sum('projects');

            $quote->update([
                'hours' => $total_hours,
                'solutions' => $total_solutions,
                'projects' => $total_projects,
                'cost' => $total_cost,
            ]);
        }
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
