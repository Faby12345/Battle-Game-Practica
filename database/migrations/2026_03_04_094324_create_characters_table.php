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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('type', 50);
            $table->integer('min_health'); $table->integer('max_health');
            $table->integer('min_strength'); $table->integer('max_strength');
            $table->integer('min_defence'); $table->integer('max_defence');
            $table->integer('min_speed'); $table->integer('max_speed');
            $table->integer('min_luck'); $table->integer('max_luck');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
