<?php

namespace App\Observers;

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

        $hours = $project->hours;

        $rate = (is_null($project->personnel)) ? 0.00 : $project->personnel->rate;
        $cost = $hours * $rate;

        $project->hours = $hours;
        $project->cost = $cost;
        $project->saveQuietly();

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

        $project->update([
            'total_hours' => $hours,
            'total_cost' => $cost,
            'rate' => $rate,
        ]);
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        $project = Project::findOrFail($project->id);

        if ($project->solution != null) {
            $countries = $project->countries;
            $branches = $project->branches;

            $hours = $project->hours;

            $rate = (is_null($project->personnel)) ? 0.00 : $project->personnel->rate;
            $cost = $hours * $rate;

            $project->hours = $hours;
            $project->cost = $cost;
            $project->saveQuietly();

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
            $project->rate = $rate;
            $project->saveQuietly();
        }

        if ($project->solution != null) {
            $solution = Solution::findOrFail($project->solution->id);

            $total_hours = $solution->projects()->where('status', true)->sum('total_hours');
            $total_cost = $solution->projects()->where('status', true)->sum('total_cost');
            $total_projects = $solution->projects()->where('status', true)->count();

            $solution->update([
                'hours' => $total_hours,
                'cost' => $total_cost,
                'projects' => $total_projects
            ]);
        }
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        if ($project->solution != null) {
            $solution = Solution::findOrFail($project->solution->id);

            $total_hours = $solution->projects()->where('status', true)->sum('total_hours');
            $total_cost = $solution->projects()->where('status', true)->sum('total_cost');
            $total_projects = $solution->projects()->where('status', true)->count();

            $solution->update([
                'hours' => $total_hours,
                'cost' => $total_cost,
                'projects' => $total_projects
            ]);
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
