<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Ingredients;
use App\Models\IngredientsTranslation;
use App\Models\Meal;
use App\Models\MealTranslation;
use App\Models\Tag;
use App\Models\TagTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::factory()
            ->count(20)
            ->has(CategoryTranslation::factory()->state(['locale' => 'hr']), 'translations')
            ->has(CategoryTranslation::factory()->state(['locale' => 'en']), 'translations')
            ->has(
                Meal::factory()->count(40)
                    ->has(MealTranslation::factory()->state(['locale' => 'hr']), 'translations')
                    ->has(MealTranslation::factory()->state(['locale' => 'en']), 'translations')
                    ->has(
                        Ingredients::factory()
                            ->has(IngredientsTranslation::factory()->state(['locale' => 'hr']), 'translations')
                            ->has(IngredientsTranslation::factory()->state(['locale' => 'en']), 'translations')
                    )
            )
            ->create();

        // Create a collection of all available tags
        $tags = Tag::factory()->count(10)
            ->has(TagTranslation::factory()->state(['locale' => 'hr']), 'translations')
            ->has(TagTranslation::factory()->state(['locale' => 'en']), 'translations')
            ->create();

        // Loop through each meal and attach random tags
        Meal::all()->each(function ($meal) use ($tags) {
            // Randomly select tags and attach them to the meal
            $meal->tags()->attach($tags->random(2)->pluck('id'));
        });

        // Soft delete some meals (change the number as needed)
        $mealsToDelete = Meal::inRandomOrder()->take(5)->get();

        foreach ($mealsToDelete as $meal) {
            $meal->delete();
        }
    }
}
