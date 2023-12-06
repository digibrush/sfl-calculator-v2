<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;

class DevelopmentPersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personnels =  \App\Models\Personnel::factory()->create([
            'title' => 'PM'
        ]);
        $personnels =  \App\Models\Personnel::factory()->create([
            'title' => 'SA'
        ]);
        $personnels =  \App\Models\Personnel::factory()->create([
            'title' => 'FC'
        ]);
        $personnels =  \App\Models\Personnel::factory()->create([
            'title' => 'FA'
        ]);
        $personnels =  \App\Models\Personnel::factory()->create([
            'title' => 'BA'
        ]);
    }
}
