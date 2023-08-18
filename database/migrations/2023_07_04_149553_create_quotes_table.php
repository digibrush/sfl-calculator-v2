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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('assignee_id')->nullable();
            $table->foreign('assignee_id')->references('id')->on('users')->onDelete('cascade');

            $table->enum('type', ['standard','simulation','template'])->default('standard');

            $table->string('title')->nullable();

            $table->string('reference')->nullable();

            $table->integer('countries')->default(1);
            $table->integer('branches')->default(1);

            $table->float('online_hours')->default(0.00);
            $table->float('offline_hours')->default(0.00);

            $table->integer('solutions')->default(0);
            $table->integer('projects')->default(0);

            $table->float('online_cost')->default(0.00);
            $table->float('offline_cost')->default(0.00);

            $table->float('discount')->default(0.00);
            $table->text('discount_note')->nullable();

            $table->float('discount_amount')->default(0.00);
            $table->float('total_cost')->default(0.00);

            $table->float('standard_online_rate')->default(0.00);
            $table->float('standard_offline_rate')->default(0.00);

            $table->float('premium_online_rate')->default(0.00);
            $table->float('premium_offline_rate')->default(0.00);

            $table->boolean('converted')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
