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
            $table->string('car_sim')->nullable();
            $table->string('car_image')->nullable();
            $table->string('car_year');
            $table->string('car_color');
            $table->unsignedBigInteger('model_id');
            $table->foreign('model_id')->references('model_id')->on('models')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('device_id');
            $table->foreign('device_id')->references('device_id')->on('devices')->onDelete('cascade')->onUpdate('cascade');
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
