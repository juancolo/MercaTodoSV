<?php

namespace App\JsonApi\Categories;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'categories';

    /**
     * @param \App\Entities\Category $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Entities\Category $category
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($category)
    {
        return [
            'name' => $category->name,
            'created-at' => $category->created_at->toAtomString(),
            'updated-at' => $category->updated_at->toAtomString(),
        ];
    }
}
