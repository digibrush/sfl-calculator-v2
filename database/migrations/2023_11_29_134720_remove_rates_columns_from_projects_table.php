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
            $table->dropColumn('standard_online_rate');
            $table->dropColumn('standard_offline_rate');

            $table->dropColumn('premium_online_rate');
            $table->dropColumn('premium_offline_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->float('standard_online_rate')->default(0.00)->after('total_cost');
            $table->float('standard_offline_rate')->default(0.00)->after('standard_online_rate');

            $table->float('premium_online_rate')->default(0.00)->after('standard_offline_rate');
            $table->float('premium_offline_rate')->default(0.00)->after('premium_online_rate');
        });
    }
};
