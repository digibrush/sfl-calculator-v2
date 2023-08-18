<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopmentSectorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = \App\Models\Sector::factory(5)->create();

        $i = 1;

        foreach ($sectors as $sector) {
            $industries = \App\Models\Industry::factory(5)->create()->each(function ($industry) use ($sector) {
                $industry->companySector()->associate($sector);
                $industry->save();
            });

            $industry = $industries->first();

            $company = \App\Models\Company::find($i);
            $company->companySector()->associate($sector);
            $company->industry()->associate($industry);
            $company->save();

            $i++;
        }
    }
}
