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
        Schema::create('recipes_has_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipes_id');
            $table->foreign('recipes_id')->references('id')->on('recipes');
            $table->unsignedBigInteger('tags_id');
            $table->foreign('tags_id')->references('id')->on('tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes_has_tags');
    }
};
