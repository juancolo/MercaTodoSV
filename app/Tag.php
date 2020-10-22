<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function products(){
        return $this->belongsToMany(Product::class, 'product_tag')->withPivot('product_id');
    }
}
