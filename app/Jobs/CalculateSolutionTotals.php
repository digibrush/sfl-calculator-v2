<?php

namespace App\Jobs;

use App\Models\Solution;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateSolutionTotals implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $solution;

    /**
     * Create a new job instance.
     */
    public function __construct(Solution $solution)
    {
        $this->solution = $solution;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $solution = $this->solution;
        $solution = Solution::findOrFail($solution->id);

        $total_hours = $solution->projects()->where('status', true)->sum('total_hours');
        $total_cost = $solution->projects()->where('status', true)->sum('total_cost');
        $total_projects = $solution->projects()->where('status', true)->count();

        $solution->hours = $total_hours;
        $solution->cost = $total_cost;
        $solution->projects = $total_projects;
        $solution->saveQuietly();

        CalculateProductTotals::dispatch($solution->product);
    }
}
