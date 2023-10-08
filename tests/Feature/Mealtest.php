<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Meal;

class MealTest extends TestCase
{
    use RefreshDatabase; //Refresh db on every test

    //Initial check for translations
    public function testCreateMealWithTranslations()
    {
        // Arrange
        $data = [
            'status' => 'created',
            'slug' => 'some-slug',
            'category' => null,
            'translations' => [
                'en' => [
                    'name' => 'English Name',
                    'title' => 'English Title',
                    'description' => 'English Description',
                ],
                'hr' => [
                    'name' => 'Croatian Name',
                    'title' => 'Croatian Title',
                    'description' => 'Croatian Description',
                ],
            ],
        ];

        // Act
        $response = $this->post('/create-meal-endpoint', $data); // Use your actual endpoint.

        // Assert
        $response->assertStatus(200); // Adjust the expected status code.
        $this->assertDatabaseHas('meals', ['slug' => 'some-slug']); // Check if the meal is in the database.
        $this->assertDatabaseHas('meals_translations', ['name' => 'English Name', 'locale' => 'en']);
        $this->assertDatabaseHas('meals_translations', ['name' => 'Croatian Name', 'locale' => 'hr']);
    }
}
