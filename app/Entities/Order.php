<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->hasMany(Product::class, 'order_product')->withPivot('product_id');
    }

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

    public function presentPrice()
    {
        return "$ ".number_format($this->total / 1);
    }
    public function getRouteKeyName()
    {
        return 'reference';
    }
}
