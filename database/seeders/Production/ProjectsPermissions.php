<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProjectsPermissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $system_administrator = Role::findByName('System Administrator');
        //projects
        $permission = Permission::create(['name' => 'Create Projects']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Projects']);
        $permission->assignRole($system_administrator);
    }
}
