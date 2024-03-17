<?php

namespace App\Repositories;

use App\Models\Domain\Ingredient;
use App\Models\Domain\Recipe;

interface IngredientRepositoryInterface
{
    public function addIngredientsToRecipe(array $ingredientIds, Recipe $recipe): ?Recipe;
    public function findById(int $id): ?Ingredient;
    public function removeAllIngredientsFromRecipe(Recipe $recipe): ?Recipe;
}
