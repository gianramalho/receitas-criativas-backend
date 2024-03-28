<?php

namespace Tests\Feature;

use App\Models\Domain\Ingredient;
use App\Models\Domain\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IngredientsTest extends TestCase
{
    public function test_list_ingredients(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->get(route('ingredients.index'));

        $response->assertStatus(200);
    }

    public function test_show_ingredient(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->get(route('ingredients.show', Ingredient::inRandomOrder()->first()->id));

        $response->assertStatus(200);
    }

    public function test_show_non_existing_ingredient (): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $response = $this->actingAs($user)
            ->withHeaders($this->PrepareHeader())
            ->get(route('ingredients.show', random_int(1000, 9999)));

        $response->assertStatus(404);
    }
}
