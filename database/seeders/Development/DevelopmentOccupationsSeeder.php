<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;

class DevelopmentOccupationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $occupations = \App\Models\Occupation::factory(10)->create();
    }
}
