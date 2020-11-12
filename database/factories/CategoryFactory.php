<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {

    $name = $faker->unique()->name();

    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'description' => $faker->sentence,
    ];
});
