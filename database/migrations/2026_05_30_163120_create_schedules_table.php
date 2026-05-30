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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // dripper, fogger
            $table->time('time'); // e.g. 06:00:00
            $table->integer('duration'); // in minutes (per approved plan)
            $table->boolean('is_active')->default(true);
            $table->json('days_of_week')->nullable(); // e.g. ["*"] or ["Monday", "Wednesday"]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
