<?php

namespace App\Repositories;

use App\Models\Domain\Recipe;
use App\Repositories\RecipeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RecipeRepository implements RecipeRepositoryInterface
{
    //TODO: Adicionar Validação
    public function listRecipes(array $filters): Collection
    {
        return Recipe::select(
            'name',
            'description',
            'preparation_time',
            'servings',
            'image',
            'difficulty',
            'author_id',
        )
            ->when(isset($filters['name']), function ($query) use ($filters) {
                return $query->where('recipes.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(isset($filters['preparation_time']), function ($query) use ($filters) {
                return $query->where('recipes.preparation_time', $filters['preparation_time']);
            })
            ->when(isset($filters['servings']), function ($query) use ($filters) {
                return $query->where('recipes.servings', $filters['servings']);
            })
            ->when(isset($filters['difficulty']), function ($query) use ($filters) {
                return $query->where('recipes.difficulty', $filters['difficulty']);
            })
            ->when(isset($filters['author_id']), function ($query) use ($filters) {
                return $query->where('recipes.author_id', $filters['author_id']);
            })
            ->get();
    }

    public function findById(int $id): ?Recipe
    {
        return Recipe::select(
            'name',
            'description',
            'preparation_time',
            'servings',
            'image',
            'difficulty',
            'author_id',
        )
            ->where('id', $id)
            ->first();
    }

    public function store(array $data): ?Recipe
    {
        return Recipe::create($data);
    }

    public function update(int $id, array $data): Collection
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->update($data);
        return $recipe;
    }

    public function delete(int $id): int
    {
        return Recipe::destroy($id);
    }
}
