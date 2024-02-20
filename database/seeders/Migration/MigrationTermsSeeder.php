<?php

namespace Database\Seeders\Migration;

use App\Models\Term;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationTermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $terms = DB::connection('data-migration')->table('tc_topics')->get();
        foreach ($terms as $term) {
            $conditions = DB::connection('data-migration')->table('tc_terms')->where('tc_topic_id', $term->id)->get();
            $term = Term::create([
                'title' => $term->name
            ]);
            $data = array();
            foreach ($conditions as $condition) {
                array_push($data, [
                    'condition' => $condition->description
                ]);
            }
            $term->update([
                'content' => $data
            ]);
        }
    }
}
