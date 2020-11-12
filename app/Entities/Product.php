<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug','details', 'description', 'actual_price', 'old_price', 'category_id', 'stock', 'file', 'status'
    ];

    public function category(){
        return $this->BelongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'product_tag')->withPivot('tag_id');
    }

    public function orders(){
        return $this->belongsToMany(Order::class, 'order_product')->withPivot('order_id');
    }

    public function presentPrice (){
        return "$ ".number_format($this->actual_price / 1);
    }

    /**
     * @param Builder $query
     * @param string|null $productInfo
     * @return Builder
     */
    public static function scopeProductInfo(Builder $query, ? string $productInfo): Builder
    {
        if(null !== $productInfo){
            return $query   ->where('name', 'like', "%$productInfo%")
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
        return $query->where('status', 'like','ACTIVO');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
