<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'details',
        'description',
        'actual_price',
        'old_price',
        'category_id',
        'stock',
        'file',
        'status'
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->BelongsTo(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tag')->withPivot('tag_id');
    }

    /**
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot('order_id');
    }

    /**
     * @return string
     */
    public function presentPrice(): string
    {
        return "$ " . number_format($this->actual_price / 1);
    }

    /**
     * @param Builder $query
     * @param string|null $productInfo
     * @return Builder
     */
    public static function scopeProductInfo(Builder $query, ?string $productInfo): Builder
    {
        if (null !== $productInfo) {
            return $query->where('name', 'like', "%$productInfo%")
                ->orWhere('actual_price', 'like', "%$productInfo%")
                ->orWhere('description', 'like', "%$productInfo%");
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public static function scopeActiveProduct(Builder $query): Builder
    {
        return $query->where('status', 'like', 'ACTIVO');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public static function scopeExport(Builder $query): Builder
    {
        return $query->select('id', 'name', 'slug', 'actual_price', 'category_id');
    }

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
