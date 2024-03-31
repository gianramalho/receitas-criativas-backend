<?php

namespace App\Http\Controllers;

use App\Application\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $validator = $this->validateRequest(
            $filters,
            [
                'name' => 'Nome',
                'preparation_time' => 'Tempo de preparação',
                'servings' => 'Porções',
                'difficulty' => 'Dificuldade',
                'author_id' => 'Autor',
                'ingredients.*' => 'Ingrediente',
                'order_by' => 'Ordenar Por',
            ],
            [
                'name' => 'nullable|max:255|string',
                'preparation_time' => 'nullable|integer|min:1',
                'servings' => 'nullable|integer|min:1',
                'difficulty' => 'nullable|integer|min:1',
                'author_id' => 'nullable|integer|min:1|exists:users,id',
                'ingredients.*' => 'nullable|integer|min:1|exists:ingredients,id',
                'order_by' => [
                    'nullable',
                    Rule::in([
                        'name',
                        'preparation_time',
                        'servings',
                        'difficulty',
                        'author_id',
                    ]),
                ],
            ],
            [
                'nome.max' => 'O :attribute informado não é válido.',
                'nome.string' => 'O :attribute informado não é válido.',
                'preparation_time.integer' => 'O :attribute informado não é válido.',
                'preparation_time.min' => 'O :attribute informado não é válido.',
                'servings.integer' => 'As :attribute informadas não são válidas.',
                'servings.min' => 'As :attribute informadas não são válidas.',
                'difficulty.integer' => 'A :attribute informada não é válida.',
                'difficulty.min' => 'A :attribute informada não é válida.',
                'author_id.integer' => 'O :attribute informado não é válido.',
                'author_id.min' => 'O :attribute informado não é válido.',
                'author_id.exists' => 'O :attribute não foi encontrado.',
                'ingredients.*.integer' => 'O :attribute informado não é válido.',
                'ingredients.*.min' => 'O :attribute informado não é válido.',
                'ingredients.*.exists' => 'O :attribute não foi encontrado.',
                'order_by.in' => 'O :attribute informado não é válido.',
            ],
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $recipes = $this->recipeService->listRecipes($filters);

        return $this->successResponse($recipes);
    }

    public function show($id)
    {
        $validator = $this->validateRequest(
            ['id' => $id],
            [
                'id' => 'Receita',
            ],
            [
                'id' => 'required|integer|min:1',
            ],
            [
                'id.required' => 'A :attribute é obrigatória.',
                'id.integer' => 'A :attribute informada não é válida.',
                'id.min' => 'A :attribute informada não é válida.',
            ],
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $recipe = $this->recipeService->findById($id);

        return $recipe ? $this->successResponse($recipe) : $this->notFoundResponse("Recipe not found");
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = $this->validateRequest(
            $data,
            [
                'name' => 'Nome',
                'description' => 'Descrição',
                'preparation_time' => 'Tempo de preparação',
                'servings' => 'Porções',
                'difficulty' => 'Dificuldade',
                'author_id' => 'Autor',
                'image' => 'Imagem',
                'ingredients.*' => 'Ingrediente',
                'instructions.*' => 'Instrução',
                'ingredients' => 'Ingredientes',
                'instructions' => 'Instruções',
            ],
            [
                'name' => 'required|max:255|string',
                'description' => 'required',
                'preparation_time' => 'required|integer|min:1',
                'servings' => 'required|integer|min:1',
                'difficulty' => 'required|integer|min:1',
                'author_id' => 'required|integer|min:1|exists:users,id',
                'image' => 'required',
                'ingredients.*' => 'integer|min:1|exists:ingredients,id',
                'ingredients' => 'required',
                'instructions' => 'required',
                'instructions.*.description' => '',
                'instructions.*.step' => 'integer|min:1',
            ],
            [
                'name.required' => 'O :attribute é obrigatório.',
                'name.max' => 'O :attribute informado não é válido.',
                'name.string' => 'O :attribute informado não é válido.',
                'description.required' => 'O :attribute é obrigatório.',
                'preparation_time.integer' => 'O :attribute informado não é válido.',
                'preparation_time.min' => 'O :attribute informado não é válido.',
                'preparation_time.required' => 'O :attribute é obrigatório.',
                'servings.integer' => 'As :attribute informadas não são válidas.',
                'servings.min' => 'As :attribute informadas não são válidas.',
                'servings.required' => 'As :attribute são obrigatórias.',
                'difficulty.integer' => 'A :attribute informada não é válida.',
                'difficulty.min' => 'A :attribute informada não é válida.',
                'difficulty.required' => 'A :attribute é obrigatória.',
                'author_id.integer' => 'O :attribute informado não é válido.',
                'author_id.min' => 'O :attribute informado não é válido.',
                'author_id.required' => 'O :attribute é obrigatório.',
                'author_id.exists' => 'O :attribute não foi encontrado.',
                'image.required' => 'A :attribute é obrigatória.',
                'ingredients.*.integer' => 'O :attribute informado não é válido.',
                'ingredients.*.min' => 'O :attribute informado não é válido.',
                'ingredients.*.exists' => 'O :attribute não foi encontrado.',
                'ingredients.required' => 'Os :attribute são obrigatórios.',
                'instructions.required' => 'As :attribute são obrigatórias.',
                'instructions.*.step.integer' => 'A :attribute informada não é válida.',
                'instructions.*.step.min' => 'A :attribute informada não é válida.',
            ],
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $recipe = $this->recipeService->store($data);

        return $this->successResponse($recipe, "Recipe created successfully");
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $data['id'] = $id;

        $validator = $this->validateRequest(
            $data,
            [
                'id' => 'Receita',
                'name' => 'Nome',
                'description' => 'Descrição',
                'preparation_time' => 'Tempo de preparação',
                'servings' => 'Porções',
                'difficulty' => 'Dificuldade',
                'author_id' => 'Autor',
                'image' => 'Imagem',
                'ingredients.*' => 'Ingrediente',
                'instructions.*' => 'Instruções',
            ],
            [
                'id' => 'required|integer|min:1|exists:recipes,id',
                'name' => 'required|max:255|string',
                'description' => 'required',
                'preparation_time' => 'required|integer|min:1',
                'servings' => 'required|integer|min:1',
                'difficulty' => 'required|integer|min:1',
                'author_id' => 'required|integer|min:1|exists:users,id',
                'image' => 'required',
                'ingredients.*' => 'integer|min:1|exists:ingredients,id',
                'instructions.*.description' => '',
                'instructions.*.step' => 'integer|min:1',
            ],
            [
                'id.required' => 'A :attribute é obrigatória.',
                'id.integer' => 'A :attribute informada não é válida.',
                'id.min' => 'A :attribute informada não é válida.',
                'id.exists' => 'A :attribute não foi encontrada.',
                'name.required' => 'O :attribute é obrigatório.',
                'name.max' => 'O :attribute informado não é válido.',
                'name.string' => 'O :attribute informado não é válido.',
                'description.required' => 'O :attribute é obrigatório.',
                'preparation_time.integer' => 'O :attribute informado não é válido.',
                'preparation_time.min' => 'O :attribute informado não é válido.',
                'preparation_time.required' => 'O :attribute é obrigatório.',
                'servings.integer' => 'As :attribute informadas não são válidas.',
                'servings.min' => 'As :attribute informadas não são válidas.',
                'servings.required' => 'As :attribute são obrigatórias.',
                'difficulty.integer' => 'A :attribute informada não é válida.',
                'difficulty.min' => 'A :attribute informada não é válida.',
                'difficulty.required' => 'A :attribute é obrigatória.',
                'author_id.integer' => 'O :attribute informado não é válido.',
                'author_id.min' => 'O :attribute informado não é válido.',
                'author_id.required' => 'O :attribute é obrigatório.',
                'author_id.exists' => 'O :attribute não foi encontrado.',
                'image.required' => 'A :attribute é obrigatória.',
                'ingredients.*.integer' => 'O :attribute informado não é válido.',
                'ingredients.*.min' => 'O :attribute informado não é válido.',
                'ingredients.*.exists' => 'O :attribute não foi encontrado.',
                'instructions.*.step.integer' => 'A :attribute informada não é válida.',
                'instructions.*.step.min' => 'A :attribute informada não é válida.',
            ],
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $recipe = $this->recipeService->update($id, $data);

        return $this->successResponse($recipe, "Recipe updated successfully");
    }

    public function delete($id)
    {
        $validator = $this->validateRequest(
            ['id' => $id],
            [
                'id' => 'Receita',
            ],
            [
                'id' => 'required|integer|min:1|exists:recipes,id',
            ],
            [
                'id.required' => 'A :attribute é obrigatória.',
                'id.integer' => 'A :attribute informada não é válida.',
                'id.min' => 'A :attribute informada não é válida.',
                'id.exists' => 'A :attribute não foi encontrada.',
            ],
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $recipe = $this->recipeService->delete($id);

        return $this->successResponse($recipe, "Recipe deleted successfully");
    }

    public function review($id, Request $request)
    {
        $data = $request->all();
        $data['id'] = $id;
        $data['device_name'] = $request->header('X-Device-Name');

        $validator = $this->validateRequest(
            $data,
            [
                'id' => 'Receita',
                'comment' => 'Comentário',
                'score' => 'Nota',
                'device_name' => 'Autor',
            ],
            [
                'id' => 'required|integer|min:1|exists:recipes,id',
                'comment' => 'required|string',
                'score' => 'required|integer|min:1|max:5',
                'device_name' => 'required|exists:devices,name',
            ],
            [
                'id.required' => 'A :attribute é obrigatória.',
                'id.integer' => 'A :attribute informada não é válida.',
                'id.min' => 'A :attribute informada não é válida.',
                'id.exists' => 'A :attribute não foi encontrada.',
                'comment.required' => 'O :attribute é obrigatório.',
                'comment.string' => 'O :attribute informado não é válido.',
                'score.required' => 'A :attribute é obrigatória.',
                'score.integer' => 'A :attribute informada não é válida.',
                'score.min' => 'A :attribute informada não é válida.',
                'score.max' => 'A :attribute informada não é válida.',
                'device_name.required' => 'O :attribute é obrigatório.',
                'device_name.exists' => 'O :attribute não foi encontrado.',
            ],
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $recipe = $this->recipeService->review($id, $data);

        return $this->successResponse($recipe, "Recipe reviewed successfully");
    }
}
