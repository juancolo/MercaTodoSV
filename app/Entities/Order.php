<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $fillable = [
        'reference',
        'user_id',
        'status',
        'first_name',
        'last_name',
        'email',
        'document_type',
        'document_number',
        'mobile',
        'address',
        'city',
        'state',
        'zip',
        'total',
        'requestId',
        'processUrl'
    ];

    protected $casts = [
        'total' => 'float'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('product_id');
    }

    /**
     * @return string
     */
    public function presentPrice(): string
    {
        return "$ " . number_format($this->total, 2);
    }

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'reference';
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithoutFinalStatus(Builder $query): Builder
    {
        return $query
            ->where('status', "PENDING")
            ->orWhere('status', "IN_PROCESS");
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdersToShow(Builder $query): Builder
    {
        return $query
            ->select('reference', 'status', 'user_id', 'total' )
            ->with('user');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeAllowed(Builder $query): Builder
    {
        if (auth()->user()->can('view', $this))
        {
            return $query;
        }
        return $query->where('user_id', auth()->id());
    }
}
