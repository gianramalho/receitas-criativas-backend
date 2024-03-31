<?php

namespace Tests\Feature;

use App\Models\Domain\Ingredient;
use App\Models\Domain\Recipe;
use App\Models\Domain\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class RecipesTest extends TestCase
{
    public function test_list_recipes(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->get(route('recipes.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'preparation_time',
                    'servings',
                    'image',
                    'difficulty',
                    'author_id',
                    'reviews',
                    'ingredients',
                    'instructions',
                    'tags',
                ]
            ]
        ]);
    }

    public function test_show_recipe(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->get(route('recipes.show', Recipe::inRandomOrder()->first()->id));

        $response->assertStatus(200);
    }

    public function test_show_non_existing_recipe(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->get(route('recipes.show', random_int(1000, 9999)));

        $response->assertStatus(404);
    }

    public function test_store_recipe(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $data = [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'preparation_time' => random_int(1, 500),
            'servings' => random_int(1, 10),
            'image' => Str::random(100),
            'difficulty' => random_int(1, 10),
            'author_id' => $user->id,
        ];

        $numInstructions = rand(1, 10);
        $steps = range(1, $numInstructions);
        shuffle($steps);

        $instructions = array_map(function ($step) {
            return [
                'description' => fake()->text(),
                'step' => $step,
            ];
        }, $steps);

        $data['instructions'] = $instructions;
        $data['ingredients'] = Ingredient::take(rand(1, 10))->inRandomOrder()->get()->pluck('id');

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->post(route('recipes.store'), $data);

        $response->assertStatus(200);
    }

    public function test_store_multiple_recipes(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $numRecipes = rand(3, 5);
        for ($i = 0; $i < $numRecipes; $i++) {
            sleep(1);
            $data = [
                'name' => fake()->name(),
                'description' => fake()->text(),
                'preparation_time' => random_int(1, 500),
                'servings' => random_int(1, 10),
                'image' => Str::random(100),
                'difficulty' => random_int(1, 10),
                'author_id' => $user->id,
            ];

            $numInstructions = rand(1, 10);
            $steps = range(1, $numInstructions);
            shuffle($steps);

            $instructions = array_map(function ($step) {
                return [
                    'description' => fake()->text(),
                    'step' => $step,
                ];
            }, $steps);

            $data['instructions'] = $instructions;
            $data['ingredients'] = Ingredient::take(rand(1, 10))->inRandomOrder()->get()->pluck('id');

            $response = $this->actingAs($user)
                ->withHeaders($this->PrepareHeader())
                ->post(route('recipes.store'), $data);

            $response->assertStatus(200);
        }
    }

    public function test_store_recipe_with_missing_required_fields(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $data = [
            'description' => fake()->text(),
            'preparation_time' => random_int(1, 500),
            'servings' => random_int(1, 10),
            'image' => Str::random(100),
            'difficulty' => random_int(1, 10),
            'author_id' => $user->id,
        ];

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->post(route('recipes.store'), $data);

        $response->assertStatus(422);
    }

    public function test_store_recipe_with_invalid_data(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $data = [
            'name' => '',
            'description' => fake()->text(),
            'preparation_time' => random_int(1, 500),
            'servings' => random_int(1, 10),
            'image' => Str::random(100),
            'difficulty' => random_int(1, 10),
            'author_id' => $user->id,
        ];

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->post(route('recipes.store'), $data);

        $response->assertStatus(422);
    }

    public function test_store_recipe_with_invalid_ingredients(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $data = [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'preparation_time' => random_int(1, 500),
            'servings' => random_int(1, 10),
            'image' => Str::random(100),
            'difficulty' => random_int(1, 10),
            'author_id' => $user->id,
            'ingredients' => [9999, 8888],
        ];

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->post(route('recipes.store'), $data);

        $response->assertStatus(422);
    }

    public function test_store_recipe_without_instructions(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $data = [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'preparation_time' => random_int(1, 500),
            'servings' => random_int(1, 10),
            'image' => Str::random(100),
            'difficulty' => random_int(1, 10),
            'author_id' => $user->id,
        ];

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->post(route('recipes.store'), $data);

        $response->assertStatus(422);
    }

    public function test_store_recipe_by_non_existent_user(): void
    {
        $data = [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'preparation_time' => random_int(1, 500),
            'servings' => random_int(1, 10),
            'image' => Str::random(100),
            'difficulty' => random_int(1, 10),
            'author_id' => null,
        ];

        $response = $this->withHeaders($this->PrepareHeader())
            ->post(route('recipes.store'), $data);

        $response->assertStatus(401);
    }

    public function test_update_recipe(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $data = [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'preparation_time' => random_int(1, 500),
            'servings' => random_int(1, 10),
            'image' => Str::random(100),
            'servings' => random_int(1, 10),
            'difficulty' => random_int(1, 10),
            'author_id' => $user->id,
        ];

        $numInstructions = rand(1, 10);
        $steps = range(1, $numInstructions);
        shuffle($steps);

        $instructions = array_map(function ($step) {
            return [
                'description' => fake()->text(),
                'step' => $step,
            ];
        }, $steps);

        $idRecipe = Recipe::inRandomOrder()->first()->id;
        $data['instructions'] = $instructions;
        $data['ingredients'] = Ingredient::take(rand(1, 10))->inRandomOrder()->get()->pluck('id');

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->post(route('recipes.update', $idRecipe), $data);

        $response->assertStatus(200);
    }

    public function test_delete_recipe(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $idRecipe = Recipe::inRandomOrder()->first()->id;

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->post(route('recipes.delete', $idRecipe));

        $response->assertStatus(200);
    }

    public function test_store_review_recipe(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $idRecipe = Recipe::inRandomOrder()->first()->id;

        $data = [
            'comment' => fake()->text(),
            'score' => random_int(1, 5),
            'author_id' => $user->id,
        ];

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->post(route('recipes.review', $idRecipe), $data);

        $response->assertStatus(200);
    }

    public function test_store_multiple_reviews(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $recipes = Recipe::all();

        $numReviews = rand(3, 5);
        foreach ($recipes as $recipe) {
            sleep(1);
            for ($i = 0; $i < $numReviews; $i++) {
                $data = [
                    'comment' => fake()->text(),
                    'score' => random_int(1, 5),
                    'author_id' => $user->id,
                ];

                $response = $this->actingAs($user)
                    ->withHeaders($this->PrepareHeader())
                    ->post(route('recipes.review', $recipe->id), $data);

                $response->assertStatus(200);
            }
        }
    }

    public function test_list_recipes_best_rated(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $filters = ['best_rated' => true];
        $route = route('recipes.index', $filters);

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->get($route);

        $response->assertStatus(200);
        $recipes = $response->json();
        $this->assertLessThanOrEqual(5, count($recipes));
    }
}
