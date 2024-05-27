<?php

namespace App\Application\Services;

use App\Models\Domain\Ingredient;
use App\Repositories\IngredientRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class IngredientService implements IngredientServiceInterface
{
    protected $ingredientRepository;

    public function __construct(IngredientRepositoryInterface $ingredientRepository)
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
