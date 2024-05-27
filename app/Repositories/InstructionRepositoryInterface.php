<?php

namespace App\Repositories;

use App\Models\Domain\Recipe;
use Illuminate\Database\Eloquent\Collection;

interface InstructionRepositoryInterface
{
    public function store(array $data, Recipe $recipe): ?Collection;
    public function deleteByRecipe(Recipe $recipe);
    public function update(array $data, Recipe $recipe): ?Collection;
}
