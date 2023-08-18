<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Rate;
use App\Models\Solution;
use Symfony\Component\Console\Output\ConsoleOutput;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $project = Project::findOrFail($project->id);

        $price_tier = $project->price_tier;
        $online_slug = $price_tier."_online_rate";
        $offline_slug = $price_tier."_offline_rate";

        $online_hours = $project->online_hours;
        $offline_hours = $project->offline_hours;

        if ($project->solution?->product?->quote == null) {
            $standard_online_rate = Rate::all()->last()->standard_online_rate;
            $standard_offline_rate = Rate::all()->last()->standard_offline_rate;
            $premium_online_rate = Rate::all()->last()->premium_online_rate;
            $premium_offline_rate = Rate::all()->last()->premium_offline_rate;

            $online_cost = $online_hours * Rate::all()->last()->$online_slug;
            $offline_cost = $offline_hours * Rate::all()->last()->$offline_slug;
        } else {
            $standard_online_rate = $project->solution->product->quote->standard_online_rate;
            $standard_offline_rate = $project->solution->product->quote->standard_offline_rate;
            $premium_online_rate = $project->solution->product->quote->premium_online_rate;
            $premium_offline_rate = $project->solution->product->quote->premium_offline_rate;

            $online_cost = $online_hours * $project->solution->product->quote->$online_slug;
            $offline_cost = $offline_hours * $project->solution->product->quote->$offline_slug;
        }

        $project->online_hours = $online_hours;
        $project->offline_hours = $offline_hours;
        $project->online_cost = $online_cost;
        $project->offline_cost = $offline_cost;
        $project->saveQuietly();

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

        $project->update([
            'total_online_hours' => $online_hours,
            'total_offline_hours' => $offline_hours,
            'total_online_cost' => $online_cost,
            'total_offline_cost' => $offline_cost,
            'standard_online_rate' => $standard_online_rate,
            'standard_offline_rate' => $standard_offline_rate,
            'premium_online_rate' => $premium_online_rate,
            'premium_offline_rate' => $premium_offline_rate,
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

            $price_tier = $project->price_tier;
            $online_slug = $price_tier."_online_rate";
            $offline_slug = $price_tier."_offline_rate";

            $online_hours = $project->online_hours;
            $offline_hours = $project->offline_hours;

            if ($project->solution->product->quote == null) {
                $standard_online_rate = Rate::all()->last()->standard_online_rate;
                $standard_offline_rate = Rate::all()->last()->standard_offline_rate;
                $premium_online_rate = Rate::all()->last()->premium_online_rate;
                $premium_offline_rate = Rate::all()->last()->premium_offline_rate;

                $online_cost = $online_hours * Rate::all()->last()->$online_slug;
                $offline_cost = $offline_hours * Rate::all()->last()->$offline_slug;
            } else {
                $standard_online_rate = $project->solution->product->quote->standard_online_rate;
                $standard_offline_rate = $project->solution->product->quote->standard_offline_rate;
                $premium_online_rate = $project->solution->product->quote->premium_online_rate;
                $premium_offline_rate = $project->solution->product->quote->premium_offline_rate;

                $online_cost = $online_hours * $project->solution->product->quote->$online_slug;
                $offline_cost = $offline_hours * $project->solution->product->quote->$offline_slug;
            }

            $project->online_hours = $online_hours;
            $project->offline_hours = $offline_hours;
            $project->online_cost = $online_cost;
            $project->offline_cost = $offline_cost;
            $project->saveQuietly();

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
            $project->standard_online_rate = $standard_online_rate;
            $project->standard_offline_rate = $standard_offline_rate;
            $project->premium_online_rate = $premium_online_rate;
            $project->premium_offline_rate = $premium_offline_rate;
            $project->saveQuietly();
        }

        if ($project->solution != null) {
            $solution = Solution::findOrFail($project->solution->id);

            $total_online_hours = $solution->projects()->where('status', true)->sum('total_online_hours');
            $total_offline_hours = $solution->projects()->where('status', true)->sum('total_offline_hours');
            $total_online_cost = $solution->projects()->where('status', true)->sum('total_online_cost');
            $total_offline_cost = $solution->projects()->where('status', true)->sum('total_offline_cost');
            $total_projects = $solution->projects()->where('status', true)->count();

            $solution->update([
                'online_hours' => $total_online_hours,
                'offline_hours' => $total_offline_hours,
                'online_cost' => $total_online_cost,
                'offline_cost' => $total_offline_cost,
                'projects' => $total_projects
            ]);
        }
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
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
