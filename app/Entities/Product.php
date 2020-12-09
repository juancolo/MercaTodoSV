<?php

namespace App\Entities;

use App\Constants\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

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

    public $allowedSorts = ['name', 'details'];

    public $type = 'products';

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
    public static function scopeProductInfo(Builder $query, string $productInfo = null): Builder
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
        return $query->where('status', 'like', 0);
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
     * @param Builder $query
     * @param $value
     */
    public function scopeName(Builder $query, $value)
    {
        $query->where('name', 'like', "%{$value}%");
    }

    /**
     * @param Builder $query
     * @param $value
     */
    public function scopeDetails(Builder $query, $value)
    {
        $query->where('details', 'like', "%{$value}%");
    }

    /**
     * @param Builder $query
     * @param $value
     */
    public function scopeMonth(Builder $query, $value)
    {
        $query->whereMonth('created_at', $value);
    }

    /**
     * @param Builder $query
     * @param $value
     */
    public function scopeYear(Builder $query, $value)
    {
        $query->whereYear('created_at', $value);
    }

    /**
     * @param Builder $query
     * @param $value
     */
    public function scopeSearch(Builder $query, $value)
    {
        foreach (Str::of($value)->explode(' ') as $value)
        {
            $query->orWhere('name', 'like', "%{$value}%")
                ->orWhere('details', 'like', "%{$value}%");
        }
    }

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return string
     */
    public function getProductImage(): string
    {
        if ($this->file == null) {
            return 'img/logo.png';
        }
        return asset($this->file);
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return ProductStatus::STATUSES[$this->status];
    }

    public function fields()
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'details' => $this->details,
            'category'=> $this->category->name,
            'description' => $this->description
        ];
    }
}
