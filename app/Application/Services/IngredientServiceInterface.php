<?php

namespace App\Application\Services;

use App\Models\Domain\Ingredient;
use Illuminate\Database\Eloquent\Collection;

interface IngredientServiceInterface
{
    public function listIngredients(array $filters) :Collection;
    public function findById(int $id) :?Ingredient;
}