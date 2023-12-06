<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateProductTotals implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $product = $this->product;
        $product = Product::findOrFail($product->id);

        $total_hours = $product->solutions()->where('status', true)->sum('hours');
        $total_cost = $product->solutions()->where('status', true)->sum('cost');
        $total_projects = $product->solutions()->where('status', true)->sum('projects');
        $total_solutions = $product->solutions()->where('status', true)->count();

        $product->hours = $total_hours;
        $product->cost = $total_cost;
        $product->projects = $total_projects;
        $product->solutions = $total_solutions;
        $product->saveQuietly();
    }
}
