<?php

namespace App\Repository;

use App\Http\Resources\MealResource;
use App\Models\Meal;
use Carbon\Carbon;

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
            //Include soft deleted meals
            $query->withTrashed();
            $date = date('Y-m-d H:i:s', $diffTime);
            $query->where(function ($query) use ($date) {
                $query->where('created_at', '>', $date)
                    ->orWhere('updated_at', '>', $date)
                    ->orWhere('deleted_at', '>', $date);
            });
        }
        if (!empty($with)) {
            $with = explode(',', $with);
            $query = $query->with($with);
        }

        $result = $query->paginate($perPage, ['*'], 'page', $page);

        // Transform the result into a MealResource collection
        $resource = MealResource::collection($result);
        return $resource;
    }
}
