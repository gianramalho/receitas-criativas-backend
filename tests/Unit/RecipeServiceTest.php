<?php

namespace Tests\Unit;

use App\Application\Services\RecipeService;
use App\Models\Domain\Recipe;
use App\Repositories\DeviceRepository;
use App\Repositories\IngredientRepository;
use App\Repositories\InstructionRepository;
use App\Repositories\RecipeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipeServiceTest extends TestCase
{
    public function testListRecipes()
    {
        $recipeRepositoryMock = $this->createMock(RecipeRepository::class);
        $recipeRepositoryMock->expects($this->once())
            ->method('listRecipes')
            ->willReturn(new Collection());

        $recipeService = new RecipeService($recipeRepositoryMock, $this->createMock(InstructionRepository::class), $this->createMock(IngredientRepository::class), $this->createMock(DeviceRepository::class));

        $recipes = $recipeService->listRecipes([]);

        $this->assertInstanceOf(Collection::class, $recipes);
    }

    public function testFindById()
    {
        $recipeRepositoryMock = $this->createMock(RecipeRepository::class);
        $recipeRepositoryMock->expects($this->once())
            ->method('findById')
            ->willReturn(new Recipe());

        $recipeService = new RecipeService($recipeRepositoryMock, $this->createMock(InstructionRepository::class), $this->createMock(IngredientRepository::class), $this->createMock(DeviceRepository::class));

        $recipe = $recipeService->findById(1);

        $this->assertInstanceOf(Recipe::class, $recipe);
    }

    public function testStore()
    {
        $recipeRepositoryMock = $this->createMock(RecipeRepository::class);
        $instructionRepositoryMock = $this->createMock(InstructionRepository::class);
        $ingredientRepositoryMock = $this->createMock(IngredientRepository::class);

        $recipeRepositoryMock->expects($this->once())
            ->method('store')
            ->willReturn(new Recipe());

        $instructionRepositoryMock->expects($this->once())
            ->method('store');

        $ingredientRepositoryMock->expects($this->once())
            ->method('addIngredientsToRecipe');

        $recipeService = new RecipeService($recipeRepositoryMock, $instructionRepositoryMock, $ingredientRepositoryMock, $this->createMock(DeviceRepository::class));

        $recipe = $recipeService->store([]);

        $this->assertInstanceOf(Recipe::class, $recipe);
    }
}
