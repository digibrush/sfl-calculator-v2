<?php

namespace App\Observers;

use App\Jobs\CalculateProjectTotals;
use App\Jobs\CalculateSolutionTotals;
use App\Models\Project;
use App\Models\Rate;
use App\Models\Solution;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $project = Project::findOrFail($project->id);

        CalculateProjectTotals::dispatch($project);
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        $project = Project::findOrFail($project->id);

        CalculateProjectTotals::dispatch($project);
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        if ($project->solution != null) {
            $solution = Solution::findOrFail($project->solution->id);

            CalculateSolutionTotals::dispatch($solution);
        }
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
