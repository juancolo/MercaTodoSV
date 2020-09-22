<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    $name = $faker->unique()->word(4);

    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'details' => $faker->text(80),
        'actualPrice' => $faker->numberBetween(1000, 2500),
        'oldPrice' => $faker->numberBetween(1000, 2500),
        'description' => $faker->text(100),
        'category_id' => rand(1, 20),
        'sales' => $faker->randomElement([1,0]),
        'visits' => $faker->randomElement([1,0]),
        'status' => $faker->randomElement(['ACTIVO', 'INACTIVO']),
        'file' => $faker->imageUrl($width = 500, $height = 400 ),
    ];
});
