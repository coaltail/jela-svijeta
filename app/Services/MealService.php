<?php

namespace App\Services;

use App\Http\Resources\MealResource;
use App\Repository\MealRepository;

class MealService
{
    private $mealRepository;

    //Inject MealRepository into MealService
    public function __construct(MealRepository $mealRepository)
    {
        $this->mealRepository = $mealRepository;
    }

    public function getMeals($perPage, $tags, $language, $with, $diffTime, $page, $category)
    {
        app()->setLocale($language);
        $meals = $this->mealRepository->getMeals($language, $category, $tags, $diffTime, $page, $perPage, $with);

        return $meals;
    }
}
