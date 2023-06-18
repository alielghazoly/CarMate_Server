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
        Schema::create('account_car', function (Blueprint $table) {
            $table->id('account_car_id');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('account_id')->on('accounts')->onDelete('cascade');
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('car_id')->on('cars')->onDelete('cascade');
            $table->enum('account_type', ['owner', 'admin', 'user']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_car');
    }
};
