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
        $personnels =  \App\Models\Personnel::factory(5)->create();
    }
}
