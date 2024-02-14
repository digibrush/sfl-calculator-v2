<?php

namespace App\Observers;

use App\Jobs\CalculateProjectTotals;
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
            $newProduct = new Product();
            $newProduct->type = $currentProduct['type'];
            $newProduct->name = $currentProduct['name'];
            $newProduct->overview = $currentProduct['overview'];
            $newProduct->image = $currentProduct['image'];
            $newProduct->video = $currentProduct['video'];
            $newProduct->status = false;
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
                $newSolution = new Solution();
                $newSolution->type = $currentSolution['type'];
                $newSolution->name = $currentSolution['name'];
                $newSolution->overview = $currentSolution['overview'];
                $newSolution->image = $currentSolution['image'];
                $newSolution->status = false;
                $newSolution->product()->associate($newProduct);
                $newSolution->saveQuietly();

                $projects = $solution->projects()->orderBy('order','ASC')->get()->each(function ($project) use ($newSolution, $quote) {
                    $personnel = $project->personnel;
                    $currentProject = $project->toArray();
                    $currentProject['id'] = null;
                    if ($quote->type == "standard") {
                        $currentProject['type'] = "quote";
                    } elseif ($quote->type == "template") {
                        $currentProject['type'] = "template";
                    } else {
                        $currentProject['type'] = "simulation";
                    }
                    $newProject = new Project();
                    $newProject->type = $currentProject['type'];
                    $newProject->name = $currentProject['name'];
                    $newProject->price_category = $currentProject['price_category'];
                    $newProject->countries = Quote::find($quote->id)->countries;
                    $newProject->branches = Quote::find($quote->id)->branches;
                    $newProject->hours = $currentProject['hours'];
                    $newProject->cost = $currentProject['cost'];
                    $newProject->rate = (is_null($project->personnel)) ? 0.00 : $project->personnel->rate;
                    $newProject->status = false;
                    $newProject->solution()->associate($newSolution);
                    $newProject->personnel()->associate($personnel);
                    $newProject->saveQuietly();

                    CalculateProjectTotals::dispatch($newProject);
                });
            });
        });

        $quote->reference = str_pad($quote->id, 8, "0", STR_PAD_LEFT);
        $quote->expires_at = now()->addDays($quote->validity_upto);
        $quote->saveQuietly();
    }

    /**
     * Handle the Quote "updated" event.
     */
    public function updated(Quote $quote): void
    {
        $quote = Quote::find($quote->id);
        $grossTotal = $quote->cost;
        $discountAmount = ($grossTotal * $quote->discount)/100;
        $netTotal = (float) ($grossTotal - $discountAmount);

        if ((float)round((float)$quote->total_cost,2) != (float)round((float)$netTotal,2) ||
            (float)round((float)$quote->discount_amount,2) != (float)round((float)$discountAmount,2)) {
            $quote->total_cost = $netTotal;
            $quote->discount_amount = $discountAmount;
            $quote->saveQuietly();
        }

        foreach ($quote->products as $product) {
            foreach ($product->solutions()->get() as $solution) {
                foreach ($solution->projects()->get() as $project) {
                    if (
                        $project->countries != $quote->countries ||
                        $project->branches != $quote->branches
                    ) {
                        $project->update([
                            'countries' => $quote->countries,
                            'branches' => $quote->branches,
                        ]);
                    }
                }
            }
        }

        $quote->expires_at = now()->addDays($quote->validity_upto);
        $quote->saveQuietly();
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
