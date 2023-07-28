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
        Schema::create('review_recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('devices_id');
            $table->foreign('devices_id')->references('id')->on('devices');
            $table->unsignedBigInteger('recipes_id');
            $table->foreign('recipes_id')->references('id')->on('recipes');
            $table->tinyInteger('score');
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_recipes');
    }
};
