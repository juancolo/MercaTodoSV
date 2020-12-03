<?php

namespace App\JsonApi\Products;

use App\Entities\Product;
use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'products';

    /**
     * @param Product $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param $product
     * @return array
     */
    public function getAttributes($product)
    {
        return [
            'name' => $product->name,
            'slug' => $product->slug,
            'details' => $product->details,
            'category'=> $product->category->name,
            'description' => $product->description,
            'created-at' => $product->created_at->toAtomString(),
            'updated-at' => $product->updated_at->toAtomString(),
        ];
    }
}
