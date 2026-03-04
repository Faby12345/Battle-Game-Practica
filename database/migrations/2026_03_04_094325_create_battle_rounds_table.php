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
        Schema::create('battle_rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('battle_id')->constrained('battles')->onDelete('cascade');
            $table->integer('round_number');
            $table->string('attacker', 50);
            $table->string('defender', 50);
            $table->integer('damage');
            $table->integer('defender_remaining_health');
            $table->string('skill_used', 100)->nullable();
            $table->text('log_message');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battle_rounds');
    }
};
