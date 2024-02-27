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

        $staff = \App\Models\User::factory()->create([
            'type' => 'staff',
            'name' => 'Reporting Manager',
            'email' => 'reporting+manager@digibrush.net'
        ]);
        $staff->assignRole(['System Administrator']);
    }
}
