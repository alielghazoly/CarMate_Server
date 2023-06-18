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
        Schema::create('cars', function (Blueprint $table) {
            $table->id('car_id');
            $table->string('car_topic');
            $table->string('car_sim');
            $table->string('car_image');
            $table->string('car_brand');
            $table->string('car_brand_image');
            $table->string('car_model');
            $table->string('car_year');
            $table->string('car_color');
            $table->unsignedBigInteger('device_id');
            $table->foreign('device_id')->references('device_id')->on('devices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
