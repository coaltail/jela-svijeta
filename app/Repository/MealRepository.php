<?php

namespace App\Repository;

use App\Http\Resources\MealResource;
use App\Models\Meal;

class MealRepository
{
    public function getMeals($language, $category, $tags, $diffTime, $page, $perPage, $with)
    {
        $query = Meal::query()->whereHas('translations', function ($query) use ($language) {
            $query->where('locale', '=', $language);
        });

        if ($category === '!NULL') {
            $query->whereNotNull('category_id');
        } elseif ($category === 'NULL') {
            $query->whereNull('category_id');
        } elseif ($category !== null) {
            $query->where('category_id', '=', $category);
        }

        if ($tags !== null) {
            $tagIds = explode(',', $tags);
            foreach ($tagIds as $tagId) {
                $query->whereHas('tags', function ($query) use ($tagId) {
                    $query->where('tag_id', '=', $tagId);
                });
            }
        }

        if ($diffTime > 0) {
            $query->where(function ($query) use ($diffTime) {
                $query->where('created_at', '>', now()->subSeconds($diffTime))
                    ->orWhere('updated_at', '>', now()->subSeconds($diffTime))
                    ->orWhere('deleted_at', '>', now()->subSeconds($diffTime));
            });
        }
        if (!empty($with)) {
            $with = explode(',', $with);
            $query = $query->with($with);
        }
        $result = $query->simplePaginate($perPage, ['*'], 'page', $page);

        // Transform the result into a MealResource collection
        $resource = MealResource::collection($result);
        return $resource;
    }
}
