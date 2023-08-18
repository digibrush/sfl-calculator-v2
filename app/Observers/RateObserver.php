<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Rate;

class RateObserver
{
    /**
     * Handle the Rate "created" event.
     */
    public function created(Rate $rate): void
    {
        //
    }

    /**
     * Handle the Rate "updated" event.
     */
    public function updated(Rate $rate): void
    {
        foreach (Project::where('type', 'standard')->get() as $project) {
            $price_tier = $project->price_tier;
            $online_slug = $price_tier."_online_rate";
            $offline_slug = $price_tier."_offline_rate";

            $project->update([
                'online_cost' => $project->online_hours * $rate->$online_slug,
                'offline_cost' => $project->offline_hours * $rate->$offline_slug,
            ]);
        }
    }

    /**
     * Handle the Rate "deleted" event.
     */
    public function deleted(Rate $rate): void
    {
        //
    }

    /**
     * Handle the Rate "restored" event.
     */
    public function restored(Rate $rate): void
    {
        //
    }

    /**
     * Handle the Rate "force deleted" event.
     */
    public function forceDeleted(Rate $rate): void
    {
        //
    }
}
