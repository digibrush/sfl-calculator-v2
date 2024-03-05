<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Development\DevelopmentCompaniesSeeder;
use Database\Seeders\Development\DevelopmentPersonnelSeeder;
use Database\Seeders\Development\DevelopmentProductsSeeder;
use Database\Seeders\Development\DevelopmentQuotesSeeder;
use Database\Seeders\Development\DevelopmentRegionSeeder;
use Database\Seeders\Development\DevelopmentSectorsSeeder;
use Database\Seeders\Development\DevelopmentUsersSeeder;
use Database\Seeders\General\RatesSeeder;
use Database\Seeders\General\RolesAndPermissionsSeeder;
use Database\Seeders\Migration\MigrationClientsSeeder;
use Database\Seeders\Migration\MigrationProductsSeeder;
use Database\Seeders\Migration\MigrationQuoteSeeder;
use Database\Seeders\Migration\MigrationRatesSeeder;
use Database\Seeders\Migration\MigrationRegionSeeder;
use Database\Seeders\Migration\MigrationTermsSeeder;
use Database\Seeders\Production\ProjectsPermissions;
use Database\Seeders\Production\QuoteProjectsHoursEditPermission;
use Database\Seeders\Production\QuotesProjectsPermissions;
use Database\Seeders\Production\QuotesSolutionsPermissions;
use Database\Seeders\Production\SolutionsPermissions;
use Database\Seeders\Production\ViewQuotesFromAllRegionsPermission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $this->call(RolesAndPermissionsSeeder::class);
//        $this->call(DevelopmentPersonnelSeeder::class);
//        $this->call(DevelopmentProductsSeeder::class);
//        $this->call(DevelopmentCompaniesSeeder::class);
//        $this->call(DevelopmentSectorsSeeder::class);
//        $this->call(DevelopmentUsersSeeder::class);
//        $this->call(DevelopmentQuotesSeeder::class);
//        $this->call(DevelopmentRegionSeeder::class);
//        $this->call(MigrationTermsSeeder::class);
//        $this->call(MigrationRegionSeeder::class);
//        $this->call(MigrationRatesSeeder::class);
//        $this->call(MigrationProductsSeeder::class);
//        $this->call(MigrationClientsSeeder::class);
//        $this->call(QuoteProjectsHoursEditPermission::class);
//        $this->call(SolutionsPermissions::class);
//        $this->call(ProjectsPermissions::class);
//        $this->call(QuotesSolutionsPermissions::class);
//        $this->call(QuotesProjectsPermissions::class);
        $this->call(ViewQuotesFromAllRegionsPermission::class);
    }
}
