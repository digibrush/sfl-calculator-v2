<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class QuotesSolutionsPermissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $system_administrator = Role::findByName('System Administrator');
        //solutions
        $permission = Permission::create(['name' => 'Create Solutions In Quotes']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Solutions In Quotes']);
        $permission->assignRole($system_administrator);
    }
}
