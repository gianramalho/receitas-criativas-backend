<?php

namespace App\Application\Services;

use App\Models\Domain\Ingredient;
use App\Repositories\IngredientRepository;
use Illuminate\Database\Eloquent\Collection;

class IngredientService implements IngredientServiceInterface
{
    protected $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    public function listIngredients(array $filters) :Collection
    {
        return $this->ingredientRepository->listIngredients($filters);
    }

    public function findById(int $id) :?Ingredient
    {
        return $this->ingredientRepository->findById($id);
    }
}
