<?php

namespace App\Repositories;

use App\Models\Domain\Ingredient;
use App\Models\Domain\Recipe;
use App\Repositories\IngredientRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class IngredientRepository implements IngredientRepositoryInterface
{
    public function addIngredientsToRecipe(array $data, Recipe $recipe): ?Recipe
    {
        $ingredientIds = $data['ingredients'];

        foreach ($ingredientIds as $ingredientId) {
            $ingredient = $this->findById($ingredientId);
            $recipe->ingredients()->attach($ingredient->id);
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
        return Ingredient::select(
            'ingredients.id',
            'ingredients.name',
            'ingredients.description',
            'ingredients.image',
        )->find($id);
    }

    public function listIngredients(array $filters): Collection
    {
        return Ingredient::select(
            'ingredients.id',
            'ingredients.name',
            'ingredients.description',
            'ingredients.image',
        )
            ->when(isset($filters['name']), function ($query) use ($filters) {
                return $query->where('ingredients.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(isset($filters['ingredients']), function ($query) use ($filters) {
                return $query->whereIn('ingredients.id', $filters['ingredients']);
            })
            ->when(isset($filters['recipes']), function ($query) use ($filters) {
                return $query->join('recipes_has_ingredients', function ($join) use ($filters) {
                    $join->on('ingredients.id', 'recipes_has_ingredients.ingredients_id')
                        ->whereIn('recipes_has_ingredients.recipes_id', $filters['recipes']);
                })->groupBy('ingredients.id', 'ingredients.name', 'ingredients.description', 'ingredients.image',);
            })
            ->get();
    }
}
