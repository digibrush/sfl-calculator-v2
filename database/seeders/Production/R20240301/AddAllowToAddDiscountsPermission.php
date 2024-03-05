<?php

namespace Database\Seeders\Production\R20240301;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddAllowToAddDiscountsPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $system_administrator = Role::findByName('System Administrator');
        //solutions
        $permission = Permission::create(['name' => 'Allow To Add Discounts']);
        $permission->assignRole($system_administrator);
    }
}
