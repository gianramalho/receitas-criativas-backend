<?php

namespace App\Http\Controllers;

use App\Application\Services\IngredientService;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    protected $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
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
        $validator = $this->validateRequest(
            $filters,
            [
                'name' => 'Nome',
            ],
            [
                'name' => 'nullable|max:255|string',
            ],
            [
                'nome.max' => 'O :attribute informado não é válido.',
                'nome.string' => 'O :attribute informado não é válido.',
            ],
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $recipes = $this->ingredientService->listIngredients($filters);

        return $this->successResponse($recipes);
    }

    public function show($id)
    {
        $validator = $this->validateRequest(
            ['id' => $id],
            [
                'id' => 'Ingrediente',
            ],
            [
                'id' => 'required|integer|min:1',
            ],
            [
                'id.required' => 'O :attribute é obrigatório.',
                'id.integer' => 'O :attribute informado não é válido.',
                'id.min' => 'O :attribute informado não é válido.',
            ],
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $ingredient = $this->ingredientService->findById($id);

        return $ingredient ? $this->successResponse($ingredient) : $this->notFoundResponse("Ingredient not found");
    }
}
