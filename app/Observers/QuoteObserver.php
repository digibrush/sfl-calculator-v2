<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\Product;
use App\Models\Project;
use App\Models\Quote;
use App\Models\Rate;
use App\Models\Solution;

class QuoteObserver
{
    /**
     * Handle the Quote "created" event.
     */
    public function created(Quote $quote): void
    {
        $quote = Quote::findOrFail($quote->id);

        $products = Product::where('type', 'standard')->orderBy('order','ASC')->get()->each(function ($product) use ($quote) {
            $currentProduct = $product->toArray();
            $currentProduct['id'] = null;
            if ($quote->type == "standard") {
                $currentProduct['type'] = "quote";
            } elseif ($quote->type == "template") {
                $currentProduct['type'] = "template";
            } else {
                $currentProduct['type'] = "simulation";
            }
            $currentProduct['status'] = false;
            $newProduct = Product::create($currentProduct);
            $newProduct->quote()->associate($quote);
            $newProduct->saveQuietly();

            $solutions = $product->solutions()->orderBy('order','ASC')->get()->each(function ($solution) use ($newProduct, $quote) {
                $currentSolution = $solution->toArray();
                $currentSolution['id'] = null;
                if ($quote->type == "standard") {
                    $currentSolution['type'] = "quote";
                } elseif ($quote->type == "template") {
                    $currentSolution['type'] = "template";
                } else {
                    $currentSolution['type'] = "simulation";
                }
                $currentSolution['status'] = false;
                $newSolution = Solution::create($currentSolution);
                $newSolution->product()->associate($newProduct);
                $newSolution->saveQuietly();

                $projects = $solution->projects()->orderBy('order','ASC')->get()->each(function ($project) use ($newSolution, $quote) {
                    $currentProject = $project->toArray();
                    $currentProject['id'] = null;
                    if ($quote->type == "standard") {
                        $currentProject['type'] = "quote";
                    } elseif ($quote->type == "template") {
                        $currentProject['type'] = "template";
                    } else {
                        $currentProject['type'] = "simulation";
                    }
                    $currentProject['countries'] = Quote::find($quote->id)->countries;
                    $currentProject['branches'] = Quote::find($quote->id)->branches;
                    $currentProject['status'] = false;
                    $newProject = Project::create($currentProject);
                    $newProject->solution()->associate($newSolution);
                    $newProject->saveQuietly();
                });
            });
        });

        $quote->reference = str_pad($quote->id, 8, "0", STR_PAD_LEFT);
        $quote->standard_online_rate = Rate::all()->last()->standard_online_rate;
        $quote->standard_offline_rate = Rate::all()->last()->standard_offline_rate;
        $quote->premium_online_rate = Rate::all()->last()->premium_online_rate;
        $quote->premium_offline_rate = Rate::all()->last()->premium_offline_rate;
        $quote->saveQuietly();
    }

    /**
     * Handle the Quote "updated" event.
     */
    public function updated(Quote $quote): void
    {
        $quote = Quote::find($quote->id);
        $grossTotal = $quote->online_cost + $quote->offline_cost;
        $discountAmount = ($grossTotal * $quote->discount)/100;
        $netTotal = (float) ($grossTotal - $discountAmount);

        if ((float)round((float)$quote->total_cost,2) != (float)round((float)$netTotal,2) ||
            (float)round((float)$quote->discount_amount,2) != (float)round((float)$discountAmount,2)) {
            $quote->update([
                'total_cost' => $netTotal,
                'discount_amount' => $discountAmount,
            ]);
        }

        foreach ($quote->products as $product) {
            foreach ($product->solutions()->get() as $solution) {
                foreach ($solution->projects()->get() as $project) {
                    if (
                        $project->countries != $quote->countries ||
                        $project->branches != $quote->branches ||
                        $project->standard_online_rate != $quote->standard_online_rate ||
                        $project->standard_offline_rate != $quote->standard_offline_rate ||
                        $project->premium_online_rate != $quote->premium_online_rate ||
                        $project->premium_offline_rate != $quote->premium_offline_rate
                    ) {
                        $project->update([
                            'countries' => $quote->countries,
                            'branches' => $quote->branches,
                            'standard_online_rate' => $quote->standard_online_rate,
                            'standard_offline_rate' => $quote->standard_offline_rate,
                            'premium_online_rate' => $quote->premium_online_rate,
                            'premium_offline_rate' => $quote->premium_offline_rate,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Handle the Quote "deleted" event.
     */
    public function deleted(Quote $quote): void
    {
        //
    }

    /**
     * Handle the Quote "restored" event.
     */
    public function restored(Quote $quote): void
    {
        //
    }

    /**
     * Handle the Quote "force deleted" event.
     */
    public function forceDeleted(Quote $quote): void
    {
        //
    }
}
