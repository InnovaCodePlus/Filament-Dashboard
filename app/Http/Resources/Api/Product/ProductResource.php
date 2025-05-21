<?php

namespace App\Http\Resources\Api\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public static $wrap = 'product';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "summary" => $this->summary,
            "description" => $this->description,
            "price" => $this->price,
            "code" => $this->code,
            "image" => $this->image,
            "category" => [
                "name" => $this->category->name,
                "slug" => $this->category->slug,
            ],
        ];
    }
}
