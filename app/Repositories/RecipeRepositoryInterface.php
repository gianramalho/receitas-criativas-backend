<?php

namespace App\Repositories;

use App\Models\Domain\Recipe;
use Illuminate\Database\Eloquent\Collection;

interface RecipeRepositoryInterface
{
    public function listRecipes(array $filters): Collection;

    public function findById(int $id): ?Recipe;

    public function store(array $data): ?Recipe;

    public function update(int $id, array $data): Collection;

    public function delete(int $id): int;
}
