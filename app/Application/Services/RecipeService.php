<?php

namespace App\Application\Services;

use App\Repositories\InstructionRepository;
use App\Repositories\RecipeRepository;
use Illuminate\Database\Eloquent\Collection;

class RecipeService implements RecipeServiceInterface
{
    //TODO: Terminar implementação dos serviços de receitas
    protected $recipeRepository;
    protected $instructionRepository;

    public function __construct(RecipeRepository $recipeRepository, InstructionRepository $instructionRepository)
    {
        $this->recipeRepository = $recipeRepository;
        $this->instructionRepository = $instructionRepository;
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
        return $this->recipeRepository->store($data);
    }

    public function update($id, array $data)
    {
        return $this->recipeRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->recipeRepository->delete($id);
    }
}
