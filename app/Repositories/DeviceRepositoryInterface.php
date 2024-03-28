<?php

namespace App\Repositories;

use App\Models\Domain\Device;
use App\Models\Domain\Recipe;

interface DeviceRepositoryInterface
{
    public function findById(int $id): ?Device;
    public function findByName(string $name): ?Device;
    public function removeAllReviewsFromRecipe(Recipe $recipe):?Recipe;
}
