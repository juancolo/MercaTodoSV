<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function presentPrice (){
        return "$ ".number_format($this->actualPrice / 1);
    }

    protected $guarded = [];
}
