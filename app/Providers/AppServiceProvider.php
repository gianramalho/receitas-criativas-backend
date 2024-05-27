<?php

namespace App\Providers;

use App\Application\Services\IngredientService;
use App\Application\Services\IngredientServiceInterface;
use App\Application\Services\RecipeService;
use App\Application\Services\RecipeServiceInterface;
use App\Repositories\DeviceRepository;
use App\Repositories\DeviceRepositoryInterface;
use App\Repositories\IngredientRepository;
use App\Repositories\IngredientRepositoryInterface;
use App\Repositories\InstructionRepository;
use App\Repositories\InstructionRepositoryInterface;
use App\Repositories\RecipeRepository;
use App\Repositories\RecipeRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IngredientServiceInterface::class, IngredientService::class);
        $this->app->bind(RecipeServiceInterface::class, RecipeService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DeviceRepositoryInterface::class, DeviceRepository::class);
        $this->app->bind(IngredientRepositoryInterface::class, IngredientRepository::class);
        $this->app->bind(InstructionRepositoryInterface::class, InstructionRepository::class);
        $this->app->bind(RecipeRepositoryInterface::class, RecipeRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
