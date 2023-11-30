<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('online_hours');
            $table->dropColumn('offline_hours');

            $table->dropColumn('online_cost');
            $table->dropColumn('offline_cost');

            $table->dropColumn('total_online_hours');
            $table->dropColumn('total_offline_hours');

            $table->dropColumn('total_online_cost');
            $table->dropColumn('total_offline_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->float('online_hours')->default(0.00)->after('branches');
            $table->float('offline_hours')->default(0.00)->after('online_hours');

            $table->float('online_cost')->default(0.00)->after('offline_hours');
            $table->float('offline_cost')->default(0.00)->after('online_cost');

            $table->float('total_online_hours')->default(0.00)->after('offline_cost');
            $table->float('total_offline_hours')->default(0.00)->after('total_online_hours');

            $table->float('total_online_cost')->default(0.00)->after('total_offline_hours');
            $table->float('total_offline_cost')->default(0.00)->after('total_online_cost');
        });
    }
};
