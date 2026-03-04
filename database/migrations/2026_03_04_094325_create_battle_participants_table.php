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
        Schema::create('battle_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('battle_id')->constrained('battles')->onDelete('cascade');
            $table->foreignId('character_id')->constrained('characters')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('type', 50);
            $table->integer('initial_health');
            $table->integer('remaining_health');
            $table->integer('strength');
            $table->integer('defence');
            $table->integer('speed');
            $table->integer('luck');
            // Note: You didn't have created_at on this table in your SQL script!
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battle_participants');
    }
};
