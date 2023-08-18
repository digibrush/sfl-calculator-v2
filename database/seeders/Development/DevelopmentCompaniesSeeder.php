<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopmentCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = \App\Models\Company::factory(5)->create();

        foreach ($companies as $company) {
            $clients = \App\Models\User::factory(2)->create([
                'type' => 'client'
            ]);

            foreach ($clients as $client) {
                $client->company()->associate($company);
                $client->save();

                $quote = \App\Models\Quote::factory()->create();
                $quote->client()->associate($client);
                $quote->save();
            }
        }
    }
}
