<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealResource;
use App\Models\Meal;
use App\Services\MealService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    protected $mealService;

    function __construct(MealService $mealService)
    {
        $this->mealService = $mealService;
    }

    public function ReturnMeals(Request $request)
    {
        // Validate, check if lang is in query param
        $validator = Validator::make($request->all(), [
            'lang' => 'bail|required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        // Retrieve possible vars from query param
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $category = $request->input('category', null);
        $tags = $request->input('tags', null);
        $with = $request->input('with');
        $lang = $request->input('lang');
        $diffTime = $request->input('diff_time', 0);
        // Call MealService to get meals
        $meals = $this->mealService->getMeals($perPage, $tags, $lang, $with, $diffTime, $page, $category);

        return $meals;
    }
}
