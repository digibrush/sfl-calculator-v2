<?php

namespace Database\Seeders\Development;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopmentQuotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quotes = Quote::factory(3)->create()->each(function ($quote) {
            $client = User::where('type','client')->where('email','john.doe@example.com')->first();
            $quote->client()->associate($client);
            $quote->save();
        });
    }
}
