<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;

class DevelopmentRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = \App\Models\Region::factory(10)->create();
    }
}
