<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\Rate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateProjectTotals implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $project;

    /**
     * Create a new job instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $project = $this->project;
        $project = Project::findOrFail($project->id);

        $price_tier = $project->price_tier;
        $online_slug = $price_tier."_online_rate";
        $offline_slug = $price_tier."_offline_rate";

        $online_hours = $project->online_hours;
        $offline_hours = $project->offline_hours;

        $online_cost = $online_hours * $project->solution->product->quote->$online_slug;
        $offline_cost = $offline_hours * $project->solution->product->quote->$offline_slug;

        $countries = $project->countries;
        $branches = $project->branches;

        if ($project->price_category == "country") {
            $online_hours = $online_hours * $countries;
            $offline_hours = $offline_hours * $countries;
            $online_cost = $online_cost * $countries;
            $offline_cost = $offline_cost * $countries;
        }

        if ($project->price_category == "branch") {
            $online_hours = $online_hours * $branches;
            $offline_hours = $offline_hours * $branches;
            $online_cost = $online_cost * $branches;
            $offline_cost = $offline_cost * $branches;
        }

        $project->total_online_hours = $online_hours;
        $project->total_offline_hours = $offline_hours;
        $project->total_online_cost = $online_cost;
        $project->total_offline_cost = $offline_cost;
        $project->saveQuietly();
    }
}
