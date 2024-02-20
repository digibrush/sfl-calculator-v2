<?php

namespace Database\Seeders\Migration;

use App\Models\Quote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrationQuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Quote::truncate();
        Schema::enableForeignKeyConstraints();
        $quotes = DB::connection('data-migration')->table('cw_inquiry')->get();
        foreach ($quotes as $quote) {
            $client = DB::connection('data-migration')->table('cw_client')->where('id', $quote->cw_client_id)->first();
            $countries = $client->countries;
            $branches = $client->branches;
            $discount = (is_null($quote->discount)) ? 0.00 : $quote->discount;
            $discount_note = $quote->discount_note;
            $newQuote = Quote::create([
                'countries' => $countries,
                'branches' => $branches,
                'discount' => $discount,
                'discount_note' => $discount_note,
            ]);
        }
    }
}
