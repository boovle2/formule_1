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
        Schema::create('races', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->string('location')->nullable();
            $table->integer('laps')->nullable();
            $table->float('distance')->nullable();
            $table->string('image')->nullable();
        });

        Schema::create('sprint_races', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('race_id')->nullable();
            $table->string('name');
            $table->date('date')->nullable();
            $table->string('location')->nullable();
            $table->integer('laps')->nullable();
            $table->float('distance')->nullable();
            

            $table->foreign('race_id')->references('id')->on('races')->onDelete('cascade');
        });

        Schema::create('qualifying_races', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('race_id')->nullable();
            $table->string('name');
            $table->date('date')->nullable();

            $table->foreign('race_id')->references('id')->on('races')->onDelete('cascade');
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('races');
        Schema::dropIfExists('sprint_Races');
        Schema::dropIfExists('qualifying_Races');
    }
};
