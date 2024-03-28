<?php

namespace App\Repositories;

use App\Models\Domain\Ingredient;
use App\Models\Domain\Recipe;
use Illuminate\Database\Eloquent\Collection;

interface IngredientRepositoryInterface
{
    public function addIngredientsToRecipe(array $ingredientIds, Recipe $recipe):?Recipe;
    public function removeAllIngredientsFromRecipe(Recipe $recipe):?Recipe;
    public function listIngredients(array $filters) :Collection;
}
