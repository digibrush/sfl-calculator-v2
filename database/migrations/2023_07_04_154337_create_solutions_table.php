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
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();

            $table->integer('order')->nullable();

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->enum('type', ['standard','quote','simulation','template'])->default('standard');

            $table->string('name');
            $table->text('overview');

            $table->string('image')->nullable();

            $table->float('online_hours')->default(0.00);
            $table->float('offline_hours')->default(0.00);

            $table->float('online_cost')->default(0.00);
            $table->float('offline_cost')->default(0.00);

            $table->integer('projects')->default(0);

            $table->boolean('status')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solutions');
    }
};
