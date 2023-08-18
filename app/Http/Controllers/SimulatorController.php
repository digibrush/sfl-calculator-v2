<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Project;
use App\Models\Quote;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SimulatorController extends Controller
{
    public function selectProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'status' => !$product->status
        ]);
        Session::flash('product',$product->id);
        return redirect()->back();
    }

    public function selectSolution($id)
    {
        $solution = Solution::findOrFail($id);
        $solution->update([
            'status' => !$solution->status
        ]);
        Session::flash('product',$solution->product->id);
        return redirect()->back();
    }

    public function selectProject($id)
    {
        $project = Project::findOrFail($id);
        $project->update([
            'status' => !$project->status
        ]);
        if (!$project->solution->status) {
            $project->solution->update([
                'status' => !$project->solution->status
            ]);
        }
        if (!$project->solution->product->status) {
            $project->solution->product->update([
                'status' => !$project->solution->product->status
            ]);
        }
        Session::flash('solution',$project->solution->id);
        return redirect()->back();
    }

    public function selectAll($id)
    {
        $quote = Quote::findOrFail($id);
        foreach ($quote->products()->get() as $product) {
            $product->update([
                'status' => true
            ]);
            foreach ($product->solutions()->get() as $solution) {
                $solution->update([
                    'status' => true
                ]);
                foreach ($solution->projects()->get() as $project) {
                    $project->update([
                        'status' => true
                    ]);
                }
            }
        }
        return redirect()->back();
    }

    public function deselectAll($id)
    {
        $quote = Quote::findOrFail($id);
        foreach ($quote->products()->get() as $product) {
            $product->update([
                'status' => false
            ]);
            foreach ($product->solutions()->get() as $solution) {
                $solution->update([
                    'status' => false
                ]);
                foreach ($solution->projects()->get() as $project) {
                    $project->update([
                        'status' => false
                    ]);
                }
            }
        }
        return redirect()->back();
    }
}
