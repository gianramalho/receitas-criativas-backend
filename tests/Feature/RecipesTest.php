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
    }

    public function test_show_recipe(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->get(route('recipes.show', random_int(1, 1000)));

        $response->assertStatus(200);
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

        $data['instructions'] = $instructions;
        $data['ingredients'] = Ingredient::take(rand(1, 10))->inRandomOrder()->get()->pluck('id');

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->post(route('recipes.store'), $data);

        $response->assertStatus(200);
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
}
