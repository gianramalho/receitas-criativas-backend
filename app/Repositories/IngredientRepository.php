<?php

namespace App\Repositories;

use App\Models\Domain\Ingredient;
use App\Models\Domain\Recipe;
use App\Repositories\IngredientRepositoryInterface;

class IngredientRepository implements IngredientRepositoryInterface
{
    public function addIngredientsToRecipe(array $data, Recipe $recipe): ?Recipe
    {
        $ingredientIds = $data['ingredients'];

        foreach ($ingredientIds as $ingredientId) {
            $ingredient = $this->findById($ingredientId);
            $recipe->ingredients()->sync($ingredient->id);
        }

        return $recipe;
    }

    public function removeAllIngredientsFromRecipe(Recipe $recipe): ?Recipe
    {
        $recipe->ingredients()->detach();

        return $recipe;
    }

    public function findById(int $id): ?Ingredient
    {
        return Ingredient::find($id);
    }
}
