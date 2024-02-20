<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Project;
use App\Models\Quote;
use App\Models\Solution;

class QuoteController extends Controller
{
    public function duplicate($id, $type = 'standard', $redirect = true)
    {
        if (isset(request()->type)) {
            if (request()->type == "simulation") {
                $type = 'simulation';
            }
        }
        $quote = Quote::findOrFail($id);
        $new_quote = new Quote();
        $new_quote->type = $type;
        $new_quote->title = null;
        $new_quote->countries = $quote->countries;
        $new_quote->branches = $quote->branches;
        $new_quote->hours = $quote->hours;
        $new_quote->solutions = $quote->solutions;
        $new_quote->projects = $quote->projects;
        $new_quote->cost = $quote->cost;
        $new_quote->discount = $quote->discount;
        $new_quote->discount_note = $quote->discount_note;
        $new_quote->discount_amount = $quote->discount_amount;
        $new_quote->total_cost = $quote->total_cost;
        $new_quote->standard_online_rate = $quote->standard_online_rate;
        $new_quote->standard_offline_rate = $quote->standard_offline_rate;
        $new_quote->premium_online_rate = $quote->premium_online_rate;
        $new_quote->premium_offline_rate = $quote->premium_offline_rate;
        $new_quote->converted = false;
        $new_quote->saveQuietly();
        $new_quote->reference = str_pad($new_quote->id, 8, "0", STR_PAD_LEFT);
        $new_quote->saveQuietly();

        foreach ($quote->products()->orderBy('order','ASC')->get() as $product) {
            $sub_type = $type;
            if ($type == 'standard') {
                $sub_type = 'quote';
            }
            $currentProduct = $product->toArray();
            $currentProduct['id'] = null;
            $currentProduct['type'] = $sub_type;
            $newProduct = Product::create($currentProduct);
            $newProduct->quote()->associate($new_quote);
            $newProduct->saveQuietly();

            foreach ($product->solutions()->orderBy('order','ASC')->get() as $solution) {
                $currentSolution = $solution->toArray();
                $currentSolution['id'] = null;
                $currentSolution['type'] = $sub_type;
                $newSolution = Solution::create($currentSolution);
                $newSolution->product()->associate($newProduct);
                $newSolution->saveQuietly();

                foreach ($solution->projects()->orderBy('order','ASC')->get() as $project) {
                    $currentProject = $project->toArray();
                    $currentProject['id'] = null;
                    $currentProject['type'] = $sub_type;
                    $currentProject['countries'] = Quote::find($new_quote->id)->countries;
                    $currentProject['branches'] = Quote::find($new_quote->id)->branches;
                    $newProject = Project::create($currentProject);
                    $newProject->solution()->associate($newSolution);
                    $newProject->saveQuietly();
                }
            }
        }
        if ($redirect) {
            return redirect()->back();
        }
        return $new_quote;
    }

    public function template($id)
    {
        $quote = Quote::findOrFail($id);
        $quote->update([
            'type' => 'template',
            'title' => 'Untitled Template'
        ]);
        foreach ($quote->products()->orderBy('order','ASC')->get() as $product) {
            $product->update([
                'type' => 'template'
            ]);

            foreach ($product->solutions()->orderBy('order','ASC')->get() as $solution) {
                $solution->update([
                    'type' => 'template'
                ]);

                foreach ($solution->projects()->orderBy('order','ASC')->get() as $project) {
                    $project->update([
                        'type' => 'template'
                    ]);
                }
            }
        }
        return redirect()->back();
    }

    public function convert($id)
    {
        $quote = $this->duplicate($id, 'standard', false);
        return redirect('/admin/quotes/'.$quote->id.'/edit');
    }

    public function simulation($id)
    {
        $quote = $this->duplicate($id, 'simulation', false);
        return redirect('/admin/simulations/'.$quote->id.'/edit');
    }
}
