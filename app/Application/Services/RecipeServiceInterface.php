<?php

namespace App\Application\Services;

use App\Models\Domain\Recipe;
use Illuminate\Database\Eloquent\Collection;

interface RecipeServiceInterface
{
    public function listRecipes(array $filters) :Collection;
    public function findById(int $id) :?Recipe;
    public function store(array $data) :?Recipe;
    public function update($id, array $data) :?Recipe;
    public function delete($id) :int;
}