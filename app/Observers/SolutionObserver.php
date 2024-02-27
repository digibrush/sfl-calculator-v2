<?php

namespace App\Observers;

use App\Jobs\CalculateProductTotals;
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

            CalculateProductTotals::dispatch($product);
        }
    }

    /**
     * Handle the Solution "updated" event.
     */
    public function updated(Solution $solution): void
    {
        $product = Product::findOrFail($solution->product->id);

        CalculateProductTotals::dispatch($product);
    }

    /**
     * Handle the Solution "deleted" event.
     */
    public function deleted(Solution $solution): void
    {
        $product = Product::findOrFail($solution->product->id);

        CalculateProductTotals::dispatch($product);
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
