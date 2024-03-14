<?php

namespace Database\Factories\Domain;

use App\Models\Domain\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->unique()->safeEmail(),
            'preparation_time' => random_int(1, 500),
            'servings' => random_int(1, 10),
            'image' => Str::random(100),
            'servings' => random_int(1, 10),
            'author_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
