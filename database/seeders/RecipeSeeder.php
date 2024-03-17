<?php

namespace Database\Seeders;

use App\Models\Domain\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipes = [
            ['id' => 1, 'name' => 'Bolo integral de banana', 'description' => 'Descrição', 'preparation_time' => 60, 'servings' => 10,'image' => 'https://renata.com.br/images/receitas/90/renata-imagem-receitas-bolo-integral-de-banana-share.jpg', 'difficulty' => 5, 'ingredients' => [18, 4]],
            ['id' => 2, 'name' => 'Misto quente de forno', 'description' => 'Descrição', 'preparation_time' => 30, 'servings' => 1,'image' => 'https://anamariabrogui.com.br/assets/uploads/receitas/fotos/usuario-2313-79f813eb9241b9d25623a100613fd84a.jpg', 'difficulty' => 1, 'ingredients' => [18, 6]],
            ['id' => 3, 'name' => 'Crepioca na frigideira', 'description' => 'Descrição', 'preparation_time' => 6, 'servings' => 1,'image' => 'https://blog.mantiqueirabrasil.com.br/wp-content/uploads/2022/11/pao-de-queijo-de-frigideira.jpeg', 'difficulty' => 4, 'ingredients' => [20, 23, 6]],
        ];

        foreach ($recipes as $recipeData) {
            $recipe = Recipe::create([
                'id' => $recipeData['id'],
                'name' => $recipeData['name'],
                'description' => $recipeData['description'],
                'preparation_time' => $recipeData['preparation_time'],
                'servings' => $recipeData['servings'],
                'image' => $recipeData['image'],
                'difficulty' => $recipeData['difficulty'],
            ]);

            $recipe->ingredients()->attach($recipeData['ingredients']);
        }
    }
}
