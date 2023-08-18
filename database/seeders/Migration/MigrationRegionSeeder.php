<?php

namespace Database\Seeders\Migration;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Region::truncate();
        $regions = DB::connection('data-migration')->table('regions')->get();
        foreach ($regions as $region) {
            $region = Region::create([
               'name' => $region->name,
               'discount' => $region->discount
            ]);
        }
    }
}
