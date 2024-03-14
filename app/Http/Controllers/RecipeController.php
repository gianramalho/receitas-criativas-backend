<?php

namespace App\Http\Controllers;

use App\Application\Services\RecipeService;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
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
}
