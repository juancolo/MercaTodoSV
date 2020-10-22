<?php

namespace App\Entities;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

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
     * @param $query
     * @param string|null $productInfo
     * @return mixed
     */
    public static function scopeProductInfo($query, ? string $productInfo)

    {
        if(null !== $productInfo){
            return $query   ->where('name', 'like', "%$productInfo%")
                            ->orWhere('actual_price', 'like', "%$productInfo%")
                            ->orWhere('description', 'like', "%$productInfo%");
        }
        return $query;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
