<?php

namespace App\Repositories;

use App\Models\Domain\Instruction;
use App\Models\Domain\Recipe;
use App\Repositories\InstructionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class InstructionRepository implements InstructionRepositoryInterface
{
    public function store(array $data, Recipe $recipe): ?Collection
    {
        $instructionsData = $data['instructions'];

        foreach ($instructionsData as $instructionData) {
            $instruction = new Instruction([
                'description' => $instructionData['description'],
                'step' => $instructionData['step'],
                'recipes_id' => $recipe->id,
            ]);

            $instruction->save();
        }

        return $recipe->instructions()->get();
    }

    public function update(array $data, Recipe $recipe): ?Collection
    {
        $recipe->instructions()->delete();
        $instructionsData = $data['instructions'];

        foreach ($instructionsData as $instructionData) {
            $instruction = new Instruction([
                'description' => $instructionData['description'],
                'step' => $instructionData['step'],
                'recipes_id' => $recipe->id,
            ]);

            $instruction->save();
        }

        return $recipe->instructions()->get();
    }

    public function deleteByRecipe(Recipe $recipe)
    {
        return $recipe->instructions()->delete();
    }
}
