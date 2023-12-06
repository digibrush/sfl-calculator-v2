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
        Schema::dropIfExists('rates');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();

            $table->float('standard_online_rate')->default(0.00);
            $table->float('standard_offline_rate')->default(0.00);

            $table->float('premium_online_rate')->default(0.00);
            $table->float('premium_offline_rate')->default(0.00);

            $table->timestamps();
        });
    }
};
