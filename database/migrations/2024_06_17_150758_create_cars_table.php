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
            $table->id();
            $table->string('mark', 100);
            $table->string('model', 255);
            $table->string('generation', 100);
            $table->integer('year');
            $table->integer('run');
            $table->string('color', 50);
            $table->string('body_type', 50);
            $table->string('engine_type', 50);
            $table->string('transmission', 50);
            $table->string('gear_type', 50);
            $table->integer('generation_id');
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
