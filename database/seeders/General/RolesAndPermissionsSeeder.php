<?php

namespace Database\Seeders\General;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        //create roles
        $system_administrator = Role::create(['name' => 'System Administrator']);
        $sales_executive = Role::create(['name' => 'Sales Executive']);
        $sales_manager = Role::create(['name' => 'Sales Manager']);

        //create permissions
        //companies
        $permission = Permission::create(['name' => 'Access Companies']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Companies']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Companies']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Companies']);
        $permission->assignRole($system_administrator);
        //clients
        $permission = Permission::create(['name' => 'Access Clients']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Clients']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Clients']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Clients']);
        $permission->assignRole($system_administrator);
        //staffs
        $permission = Permission::create(['name' => 'Access Staffs']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Staffs']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Staffs']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Staffs']);
        $permission->assignRole($system_administrator);
        //products
        $permission = Permission::create(['name' => 'Access Products']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Products']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Products']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Products']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Reorder Products']);
        $permission->assignRole($system_administrator);
        //quotes
        $permission = Permission::create(['name' => 'Access Quotes']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Quotes']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Quotes']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Quotes']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Duplicate Quotes']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Access Calender Quotes']);
        $permission->assignRole($system_administrator);
        //simulations
        $permission = Permission::create(['name' => 'Access Simulations']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Simulations']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Simulations']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Simulations']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Duplicate Simulations']);
        $permission->assignRole($system_administrator);
        //templates
        $permission = Permission::create(['name' => 'Access Templates']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Templates']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Templates']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Templates']);
        $permission->assignRole($system_administrator);
        //users
        $permission = Permission::create(['name' => 'Access Users']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Users']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Users']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Users']);
        $permission->assignRole($system_administrator);
        //sectors
        $permission = Permission::create(['name' => 'Access Sectors']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Sectors']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Sectors']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Sectors']);
        $permission->assignRole($system_administrator);
        //regions
        $permission = Permission::create(['name' => 'Access Regions']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Regions']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Regions']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Regions']);
        $permission->assignRole($system_administrator);
        //permissions
        $permission = Permission::create(['name' => 'Access Permissions']);
        $permission->assignRole($system_administrator);
        //roles
        $permission = Permission::create(['name' => 'Access Roles']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Roles']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Roles']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Roles']);
        $permission->assignRole($system_administrator);
        //terms and conditions
        $permission = Permission::create(['name' => 'Access Terms And Conditions']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Terms And Conditions']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Terms And Conditions']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Terms And Conditions']);
        $permission->assignRole($system_administrator);
        //personnel
        $permission = Permission::create(['name' => 'Access Personnels']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Create Personnels']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Edit Personnels']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Delete Personnels']);
        $permission->assignRole($system_administrator);
        //discount
        $permission = Permission::create(['name' => 'Discount upto -5']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -10']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -15']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -20']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -25']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -30']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -35']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -40']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -45']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -50']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -55']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -60']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -65']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -70']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -75']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -80']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -85']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -90']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -95']);
        $permission->assignRole($system_administrator);
        $permission = Permission::create(['name' => 'Discount upto -100']);
        $permission->assignRole($system_administrator);
    }
}
