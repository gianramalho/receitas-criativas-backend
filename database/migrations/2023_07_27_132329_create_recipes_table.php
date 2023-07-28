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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description');
            $table->integer('preparation_time'); // Duração de preparo em minutos
            $table->integer('cooking_time'); // Tempo de cozimento em minutos
            $table->integer('servings'); // Número de porções
            $table->json('ingredients'); // Lista de ingredientes em formato JSON
            $table->text('instructions'); // Instruções para preparo da receita
            $table->string('difficulty'); // Dificuldade da receita
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
