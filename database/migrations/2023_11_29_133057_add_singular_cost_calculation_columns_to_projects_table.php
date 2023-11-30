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
            $table->float('hours')->default(0.00)->after('branches');

            $table->float('cost')->default(0.00)->after('hours');

            $table->float('total_hours')->default(0.00)->after('cost');

            $table->float('total_cost')->default(0.00)->after('total_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('hours');

            $table->dropColumn('cost');

            $table->dropColumn('total_hours');

            $table->dropColumn('total_cost');
        });
    }
};
