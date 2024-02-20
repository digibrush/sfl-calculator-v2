<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;

class DevelopmentUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = \App\Models\User::factory()->create([
            'type' => 'staff',
            'name' => 'Pasindu Premaratne',
            'email' => 'pasindu+staff@digibrush.net'
        ]);
        $staff->assignRole(['System Administrator']);

//        $client = \App\Models\User::factory()->create([
//            'type' => 'client',
//            'name' => 'John Doe',
//            'email' => 'john.doe@example.com'
//        ]);
//        $client->company()->associate(Company::find(1));
//        $client->save();
    }
}
