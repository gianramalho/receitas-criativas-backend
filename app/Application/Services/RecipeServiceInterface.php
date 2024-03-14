<?php

namespace App\Application\Services;

use Illuminate\Database\Eloquent\Collection;

interface RecipeServiceInterface
{
    public function listRecipes(array $filters): Collection;
}