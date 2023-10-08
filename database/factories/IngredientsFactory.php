<?php

namespace Database\Factories;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

class IngredientsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word;
        $uniqueId = Str::uuid()->toString();
        $slug = 'ingredient-' . Str::slug($name) . '-' . $uniqueId;
        return [
            'slug' => $slug,
        ];
    }
}
