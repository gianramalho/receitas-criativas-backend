<?php

use App\Http\Controllers\authentication\AuthenticationController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'verify.device.exists'], function () {
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::get('/login', [AuthenticationController::class, 'loginMandatory'])->name('login');


        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::name('recipes.')
            ->prefix('recipes')
            ->group(function () {
                Route::get('/', [RecipeController::class, 'index'])->name('index');
                Route::get('/{id}', [RecipeController::class, 'show'])->name('show');
                Route::post('/review/{id}', [RecipeController::class, 'review'])->name('review');

                Route::middleware(['auth:sanctum'])->group(function () {
                    Route::post('/', [RecipeController::class, 'store'])->name('store');
                    Route::post('/update/{id}', [RecipeController::class, 'update'])->name('update');
                    Route::post('/delete/{id}', [RecipeController::class, 'delete'])->name('delete');
                });

            });

        Route::name('ingredients.')
            ->prefix('ingredients')
            ->group(function () {
                Route::get('/', [IngredientController::class, 'index'])->name('index');
                Route::get('/{id}', [IngredientController::class, 'show'])->name('show');
            });
});
