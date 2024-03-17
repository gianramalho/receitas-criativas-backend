<?php

namespace App\Application\Services;

use App\Repositories\IngredientRepository;
use App\Repositories\InstructionRepository;
use App\Repositories\RecipeRepository;
use Illuminate\Database\Eloquent\Collection;

class RecipeService implements RecipeServiceInterface
{
    protected $recipeRepository;
    protected $instructionRepository;
    protected $ingredientRepository;

    public function __construct(RecipeRepository $recipeRepository, InstructionRepository $instructionRepository, IngredientRepository $ingredientRepository)
    {
        $this->recipeRepository = $recipeRepository;
        $this->instructionRepository = $instructionRepository;
        $this->ingredientRepository = $ingredientRepository;
    }

    public function listRecipes(array $filters): Collection
    {
        return $this->recipeRepository->listRecipes($filters);
    }

    public function findById($id)
    {
        return $this->recipeRepository->findById($id);
    }

    public function store(array $data)
    {
        $recipe = $this->recipeRepository->store($data);
        $this->instructionRepository->store($data, $recipe);
        $this->ingredientRepository->addIngredientsToRecipe($data, $recipe);

        return $recipe;
    }

    public function update($id, array $data)
    {
        $recipe = $this->recipeRepository->update($id, $data);
        $this->instructionRepository->update($data, $recipe);
        $this->ingredientRepository->addIngredientsToRecipe($data, $recipe);

        return $recipe;
    }

    public function delete($id)
    {
        $recipe = $this->recipeRepository->findById($id);
        
        // Remover todas as instruções associadas à receita
        $this->instructionRepository->deleteByRecipe($recipe);
        
        // Remover todos os ingredientes associados à receita
        $this->ingredientRepository->removeAllIngredientsFromRecipe($recipe);
        
        // Excluir a receita
        return $this->recipeRepository->delete($id);
    }
}
