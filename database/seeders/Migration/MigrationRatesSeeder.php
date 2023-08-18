<?php

namespace Database\Seeders\Migration;

use App\Models\Rate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rate::truncate();
        $organisation = DB::connection('data-migration')->table('organisations')->first();
        $standard_online_rate = $organisation->online_hourly_rate;
        $standard_offline_rate = $organisation->offline_hourly_rate;
        $premium_online_rate = $organisation->premium_online_hourly_rate;
        $premium_offline_rate = $organisation->premium_offline_hourly_rate;
        $rate = Rate::create([
            'standard_online_rate' => $standard_online_rate,
            'standard_offline_rate' => $standard_offline_rate,
            'premium_online_rate' => $premium_online_rate,
            'premium_offline_rate' => $premium_offline_rate,
        ]);
    }
}
