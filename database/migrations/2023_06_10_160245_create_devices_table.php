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
        Schema::create('devices', function (Blueprint $table) {
            $table->id('device_id');
            $table->string('device_random_id')->unique();
            $table->string('device_wifi_name')->unique();
            $table->string('device_wifi_pass');
            $table->string('device_first_key')->unique();
            $table->enum('device_status', ['generated', 'programmed', 'installed', 'uninstalled'])->default('generated');
            $table->decimal('device_version');
            $table->string('device_date');
            $table->string('device_serial');
            $table->string('device_qr');
            $table->string('device_mqtt_topic')->unique();
            $table->boolean('device_qr_printed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
