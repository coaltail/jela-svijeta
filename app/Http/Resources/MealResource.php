<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'title' => $this->title,
            'description' => $this->description,
            'category' => new CategoryResource($this->whenLoaded('category')), // Assuming you have a CategoryResource
            'tags' => TagResource::collection($this->whenLoaded('tags')), // Assuming you have a TagResource
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')), // Assuming you have an IngredientResource
        ];
    }
}
