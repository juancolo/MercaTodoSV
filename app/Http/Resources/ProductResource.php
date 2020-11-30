<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'product',
            'id' => $this->resource->getRouteKey(),
            'attributes' => [
                'name' => $this->resource->name,
                'slug' => $this->resource->slug,
                'details' => $this->resource->details,
                'category'=> $this->resource->category->name,
                'description' => $this->resource->description
            ],
            'link' => [
                'self' => route('api.v1.products.show', $this->resource)
            ]
        ];
    }
}
