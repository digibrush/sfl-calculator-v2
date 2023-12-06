<?php

namespace Database\Seeders\Migration;

use App\Models\Personnel;
use App\Models\Product;
use App\Models\Project;
use App\Models\Solution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrationProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Solution::truncate();
        Project::truncate();
        Schema::enableForeignKeyConstraints();
        if (env('MIGRATION_MECHANISM') == 'database') {
            $products = DB::connection('data-migration')->table('cw_module')->orderBy('cw_order')->get();
            $product_order = 1;
            foreach ($products as $product) {
                $status = false;
                if ($product->status == 'ACTIVE') {
                    $status = true;
                }
                $new_product = Product::create([
                    'order' => $product_order,
                    'name' => $product->name,
                    'overview' => $product->description,
                    'video' => $product->enbed_url,
                    'status' => $status,
                ]);
                $solutions = DB::connection('data-migration')->table('cw_task')->where('cw_module_id', $product->id)->whereNull('parent_id')->orderBy('cw_order')->get();
                $solution_order = 1;
                foreach ($solutions as $solution) {
                    $status = false;
                    if ($solution->status == 'ACTIVE') {
                        $status = true;
                    }
                    $new_solution = Solution::create([
                        'order' => $solution_order,
                        'name' => $solution->name,
                        'overview' => ' ',
                        'status' => $status,
                    ]);
                    $new_solution->product()->associate($new_product);
                    $new_solution->save();
                    $projects = DB::connection('data-migration')->table('cw_task')->where('cw_module_id', $product->id)->where('parent_id', $solution->id)->orderBy('cw_order')->get();
                    $project_order = 1;
                    foreach ($projects as $project) {
                        $status = false;
                        if ($solution->status == 'ACTIVE') {
                            $status = true;
                        }
                        $new_project = Project::create([
                            'order' => $project_order,
                            'name' => $project->name,
                            'price_category' => ($project->solution_type != 'default') ? ($project->solution_type == null) ? 'standard' : $project->solution_type : 'standard',
                            'price_tier' => ($project->task_type == null) ? 'standard' : $project->task_type,
                            'online_hours' => ($project->online_hours == null) ? 0 : $project->online_hours,
                            'offline_hours' => ($project->offline_hours == null) ? 0 : $project->offline_hours,
                            'status' => $status,
                        ]);
                        $new_project->solution()->associate($new_solution);
                        $new_project->save();
                        $project_order++;
                    }
                    $solution_order++;
                }
                $product_order++;
            }
        } else {
            $content = [];
            if (($open = fopen(public_path() . "/data/20231206.csv", "r")) !== FALSE) {
                while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                    $content[] = $data;
                }
                fclose($open);
            }
            if (count($content) != 0) {
                $product = null;
                $solution = null;
                foreach ($content as $row) {
                    if (strtolower($row[3]) == "product") {
                        $product = Product::create([
                            'name' => $row[0],
                            'overview' => ' ',
                            'status' => true,
                        ]);
                    }
                    if (strtolower($row[3]) == "solution") {
                        $solution = Solution::create([
                            'name' => $row[1],
                            'overview' => ' ',
                            'status' => true,
                        ]);
                        $solution->product()->associate($product);
                        $solution->save();
                    }
                    if (strtolower($row[3]) == "project") {
                        $project = Project::create([
                            'name' => $row[2],
                            'hours' => $row[4],
                            'status' => true,
                        ]);
                        $project->solution()->associate($solution);
                        $project->save();
                        if ($row[5] != "") {
                            $project->personnel()->associate(Personnel::where('title',$row[5])->first());
                            $project->save();
                        }
                    }
                }
            }
        }

    }
}
