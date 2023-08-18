<?php

namespace Database\Seeders\Migration;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MigrationClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Company::truncate();
        User::where('type','client')->delete();
        Schema::enableForeignKeyConstraints();
        $companies = DB::connection('data-migration')->table('cw_client')->select('company_name','country')->distinct('company_name')->get();
        foreach ($companies as $company) {
            $new_company = Company::create([
                'name' => $company->company_name,
                'city' => ' ',
                'country' => $company->country
            ]);
            $clients = DB::connection('data-migration')->table('cw_client')->where('company_name', $company->company_name)->where('country', $company->country)->get();
            foreach ($clients as $client) {
                $new_client = User::create([
                    'type' => 'client',
                    'name' => $client->first_name.' '.$client->last_name,
                    'email' => $client->email,
                    'password' => Hash::make('password')
                ]);
                $new_client->company()->associate($new_company);
                $new_client->save();
            }
        }
    }
}
