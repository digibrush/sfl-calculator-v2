<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;

class DevelopmentProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::factory(5)->create()->each(function ($product) {
            \App\Models\Solution::factory(4)->create()->each(function ($solution) use ($product) {
                $solution->product()->associate($product);
                $solution->save();
                \App\Models\Project::factory(4)->create()->each(function ($project) use ($solution) {
                    $project->solution()->associate($solution);
                    $project->save();
                });
            });
        });
    }
}
