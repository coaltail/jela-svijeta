<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Route;

class MealResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $status = $this->getStatus();
        return [
            'id' => $this->id,
            'status' => $status,
            'title' => $this->title,
            'description' => $this->description,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')),
        ];
    }
    private function getStatus()
    {
        // If deleted_at is not null, automatically return deleted.
        if ($this->resource->deleted_at !== null) {
            return 'deleted';
        }

        $diffTime = $this->resource->created_at->diffInSeconds(Carbon::now());

        if ($diffTime >= 0) {
            //Created_at is greater or equal to updated_at, return created
            if ($this->resource->created_at >= $this->resource->updated_at) {
                return 'created';
            } else {
                return 'modified';
            }
        }

        return 'created';
    }
}
