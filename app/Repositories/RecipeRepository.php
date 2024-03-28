<?php

namespace App\Repositories;

use App\Models\Domain\Device;
use App\Models\Domain\Recipe;
use App\Repositories\RecipeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RecipeRepository implements RecipeRepositoryInterface
{
    public function listRecipes(array $filters): Collection
    {
        return Recipe::select(
            'recipes.id',
            'recipes.name',
            'recipes.description',
            'recipes.preparation_time',
            'recipes.servings',
            'recipes.image',
            'recipes.difficulty',
            'recipes.author_id',
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
            ->when(isset($filters['ingredients']), function ($query) use ($filters) {
                return $query->join('recipes_has_ingredients', function ($join) use ($filters) {
                    $join->on('recipes.id', 'recipes_has_ingredients.recipes_id')
                        ->whereIn('recipes_has_ingredients.ingredients_id', $filters['ingredients']);
                })->groupBy('recipes.id', 'recipes.name', 'recipes.description', 'recipes.preparation_time', 'recipes.servings', 'recipes.image', 'recipes.difficulty', 'recipes.author_id');
            })
            ->with('ingredients')
            ->with('instructions')
            ->with('reviews')
            ->with('tags')
            ->get();
    }

    public function findById(int $id): ?Recipe
    {
        return Recipe::select(
            'recipes.id',
            'recipes.name',
            'recipes.description',
            'recipes.preparation_time',
            'recipes.servings',
            'recipes.image',
            'recipes.difficulty',
            'recipes.author_id',
        )
            ->with('ingredients')
            ->with('instructions')
            ->with('reviews')
            ->with('tags')
            ->where('id', $id)
            ->first();
    }

    public function store(array $data): ?Recipe
    {
        return Recipe::create($data);
    }

    public function update(int $id, array $data): ?Recipe
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->update($data);
        return $recipe;
    }

    public function review(int $id, Device $device, array $data): ?Recipe
    {
        $recipe = Recipe::findOrFail($id);

        $recipe->reviews()->sync([$device->id => [
            'score' => $data['score'],
            'comment' => $data['comment'],
        ]]);

        return $recipe;
    }

    public function delete(int $id): int
    {
        return Recipe::destroy($id);
    }
}
