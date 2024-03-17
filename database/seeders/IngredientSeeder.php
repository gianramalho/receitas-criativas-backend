<?php

namespace Database\Seeders;

use App\Models\Domain\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            ['id' => 1, 'name' => 'Abacate', 'image' => 'avocado.png', 'description' => 'Descrição'],
            ['id' => 2, 'name' => 'Maça', 'image' => 'apple.png', 'description' => 'Descrição'],
            ['id' => 3, 'name' => 'Bacon', 'image' => 'bacon.png', 'description' => 'Descrição'],
            ['id' => 4, 'name' => 'Banana', 'image' => 'banana.png', 'description' => 'Descrição'],
            ['id' => 5, 'name' => 'Brócolis', 'image' => 'broccoli.png', 'description' => 'Descrição'],
            ['id' => 6, 'name' => 'Queijo', 'image' => 'cheese.png', 'description' => 'Descrição'],
            ['id' => 7, 'name' => 'Coco', 'image' => 'coconut.png', 'description' => 'Descrição'],
            ['id' => 8, 'name' => 'Milho', 'image' => 'corn.png', 'description' => 'Descrição'],
            ['id' => 9, 'name' => 'Pepino', 'image' => 'cucumber.png', 'description' => 'Descrição'],
            ['id' => 10, 'name' => 'Berinjela', 'image' => 'eggplant.png', 'description' => 'Descrição'],
            ['id' => 11, 'name' => 'Alho', 'image' => 'garlic.png', 'description' => 'Descrição'],
            ['id' => 12, 'name' => 'Mel', 'image' => 'honey.png', 'description' => 'Descrição'],
            ['id' => 13, 'name' => 'Kiwi', 'image' => 'kiwi.png', 'description' => 'Descrição'],
            ['id' => 14, 'name' => 'Carne', 'image' => 'meat.png', 'description' => 'Descrição'],
            ['id' => 15, 'name' => 'Cebola', 'image' => 'onion.png', 'description' => 'Descrição'],
            ['id' => 16, 'name' => 'Panquecas', 'image' => 'pancake.png', 'description' => 'Descrição'],
            ['id' => 17, 'name' => 'Massa', 'image' => 'pasta.png', 'description' => 'Descrição'],
            ['id' => 18, 'name' => 'Ovo', 'image' => 'eggs.png', 'description' => 'Descrição'],
            ['id' => 19, 'name' => 'Batata', 'image' => 'potatoes.png', 'description' => 'Descrição'],
            ['id' => 20, 'name' => 'Lanche', 'image' => 'snack.png', 'description' => 'Descrição'],
            ['id' => 21, 'name' => 'Morango', 'image' => 'strawberry.png', 'description' => 'Descrição'],
            ['id' => 22, 'name' => 'Tangirina', 'image' => 'tangerine.png', 'description' => 'Descrição'],
            ['id' => 23, 'name' => 'Tomate', 'image' => 'tomato.png', 'description' => 'Descrição'],
            ['id' => 24, 'name' => 'Alface', 'image' => 'vegetables.png', 'description' => 'Descrição'],
            ['id' => 25, 'name' => 'Melancia', 'image' => 'watermelon.png', 'description' => 'Descrição'],
            ['id' => 26, 'name' => 'Carne', 'image' => 'meat.png', 'description' => 'Descrição']
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
