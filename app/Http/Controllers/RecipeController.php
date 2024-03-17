<?php

namespace App\Http\Controllers;

use App\Application\Services\RecipeService;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    //TODO: Tratar melhor os códigos de status da response
    protected $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    /**
     * index
     *
     * @param  mixed $request
     * @return Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $recipes = $this->recipeService->listRecipes($filters);

        if ($recipes) {
            return response()->json([
                'data' => $recipes,
                'message' => "",
            ], 200);
        } else {
            return response()->json([
                'message' => 'Recipes not found'
            ], 200);
        }
    }

    public function show($id)
    {
        $recipe = $this->recipeService->findById($id);

        if ($recipe) {
            return response()->json([
                'data' => $recipe,
                'message' => "",
            ], 200);
        } else {
            return response()->json([
                'message' => 'Recipe not found'
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $recipe = $this->recipeService->store($data);

        return response()->json([
            'data' => $recipe,
            'message' => "Recipe created successfully",
        ], 200);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $recipe = $this->recipeService->update($id, $data);

        return response()->json([
            'data' => $recipe,
            'message' => "Recipe updated successfully",
        ], 200);
    }

    public function delete($id)
    {
        $recipe = $this->recipeService->delete($id);

        return response()->json([
            'data' => $recipe,
            'message' => "Recipe deleted successfully",
        ], 200);
    }
}
