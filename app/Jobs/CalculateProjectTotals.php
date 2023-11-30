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

        $hours = $project->hours;

        $rate = (is_null($project->personnel)) ? 0.00 : $project->personnel->rate;
        $cost = $hours * $rate;

        $countries = $project->countries;
        $branches = $project->branches;

        if ($project->price_category == "country") {
            $hours = $hours * $countries;
            $cost = $cost * $countries;
        }

        if ($project->price_category == "branch") {
            $hours = $hours * $branches;
            $cost = $cost * $branches;
        }

        $project->total_hours = $hours;
        $project->total_cost = $cost;
        $project->saveQuietly();
    }
}
