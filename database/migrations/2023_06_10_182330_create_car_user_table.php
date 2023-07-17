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
        Schema::create('car_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');;
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('car_id')->on('cars')->onDelete('cascade')->onUpdate('cascade');;
            $table->enum('user_type', ['owner', 'admin', 'user']);
            $table->string('user_app_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_user');
    }
};
