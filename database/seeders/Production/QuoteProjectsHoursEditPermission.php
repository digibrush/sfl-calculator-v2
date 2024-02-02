<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class QuoteProjectsHoursEditPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $system_administrator = Role::findByName('System Administrator');

        //quotes
        $permission = Permission::create(['name' => 'Edit Project Hours In Quotes']);
        $permission->assignRole($system_administrator);
    }
}
