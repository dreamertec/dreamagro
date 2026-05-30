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
        Schema::create('device_settings', function (Blueprint $table) {
            $table->id();
            $table->string('mode')->default('manual'); // auto, manual, disabled
            $table->string('dripper_override')->default('OFF'); // ON, OFF
            $table->string('fogger_override')->default('OFF'); // ON, OFF
            $table->string('motor_override')->default('OFF'); // ON, OFF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_settings');
    }
};
