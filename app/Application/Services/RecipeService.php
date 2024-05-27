<?php

namespace App\Application\Services;

use App\Models\Domain\Recipe;
use App\Repositories\DeviceRepositoryInterface;
use App\Repositories\IngredientRepositoryInterface;
use App\Repositories\InstructionRepositoryInterface;
use App\Repositories\RecipeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RecipeService implements RecipeServiceInterface
{
    protected $recipeRepository;
    protected $instructionRepository;
    protected $ingredientRepository;
    protected $deviceRepository;

    public function __construct(RecipeRepositoryInterface $recipeRepository, InstructionRepositoryInterface $instructionRepository, IngredientRepositoryInterface $ingredientRepository, DeviceRepositoryInterface $deviceRepository)
    {
        $this->recipeRepository = $recipeRepository;
        $this->instructionRepository = $instructionRepository;
        $this->ingredientRepository = $ingredientRepository;
        $this->deviceRepository = $deviceRepository;
    }

    public function listRecipes(array $filters): Collection
    {
        return $this->recipeRepository->listRecipes($filters);
    }

    public function findById(int $id): ?Recipe
    {
        return $this->recipeRepository->findById($id);
    }

    public function store(array $data): ?Recipe
    {
        return DB::transaction(function () use ($data) {
            $recipe = $this->recipeRepository->store($data);
            $this->instructionRepository->store($data, $recipe);
            $this->ingredientRepository->addIngredientsToRecipe($data, $recipe);

            return $recipe;
        });
    }

    public function update($id, array $data): ?Recipe
    {
        return DB::transaction(function () use ($id, $data) {
            $recipe = $this->recipeRepository->update($id, $data);
            $this->instructionRepository->update($data, $recipe);
            $this->ingredientRepository->removeAllIngredientsFromRecipe($recipe);
            $this->ingredientRepository->addIngredientsToRecipe($data, $recipe);

            return $recipe;
        });
    }

    public function delete($id): int
    {
        return DB::transaction(function () use ($id) {
            $recipe = $this->recipeRepository->findById($id);

            // Remover todas as instruções associadas à receita
            $this->instructionRepository->deleteByRecipe($recipe);

            // Remover todos os ingredientes associados à receita
            $this->ingredientRepository->removeAllIngredientsFromRecipe($recipe);

            // Remover todas as reviews associadas à receita
            $this->deviceRepository->removeAllReviewsFromRecipe($recipe);

            // Excluir a receita
            return $this->recipeRepository->delete($id);
        });
    }

    public function review($id, array $data): ?Recipe
    {

        return DB::transaction(function () use ($id, $data) {
            $device = $this->deviceRepository->findByName($data['device_name']);
            $recipe = $this->recipeRepository->review($id, $device, $data);

            return $recipe;
        });
    }
}
