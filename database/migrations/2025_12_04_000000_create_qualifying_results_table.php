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
        Schema::create('qualifying_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qualifying_race_id');
            $table->unsignedBigInteger('driver_id');
            $table->integer('placement')->default(0);
            $table->string('time')->nullable();

            $table->foreign('qualifying_race_id')->references('id')->on('qualifying_races')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualifying_results');
    }
};
