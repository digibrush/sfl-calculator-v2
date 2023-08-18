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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->integer('order')->nullable();

            $table->unsignedBigInteger('solution_id')->nullable();
            $table->foreign('solution_id')->references('id')->on('solutions')->onDelete('cascade');

            $table->enum('type', ['standard','quote','simulation','template'])->default('standard');

            $table->string('name');

            $table->enum('price_category', ['standard','branch','country'])->default('standard');
            $table->enum('price_tier', ['standard','premium'])->default('standard');

            $table->integer('countries')->default(1);
            $table->integer('branches')->default(1);

            $table->float('online_hours')->default(0.00);
            $table->float('offline_hours')->default(0.00);

            $table->float('online_cost')->default(0.00);
            $table->float('offline_cost')->default(0.00);

            $table->float('total_online_hours')->default(0.00);
            $table->float('total_offline_hours')->default(0.00);

            $table->float('total_online_cost')->default(0.00);
            $table->float('total_offline_cost')->default(0.00);

            $table->float('standard_online_rate')->default(0.00);
            $table->float('standard_offline_rate')->default(0.00);

            $table->float('premium_online_rate')->default(0.00);
            $table->float('premium_offline_rate')->default(0.00);

            $table->boolean('status')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
