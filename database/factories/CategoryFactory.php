<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {

    $name = $faker->unique()->word();

    return [
        'name' => $name,
        'details' => $this->faker->sentence,
        'slug' => Str::slug($name),
    ];
});
