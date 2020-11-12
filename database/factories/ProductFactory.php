<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    $name = $faker->unique()->name();

    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'details' => $faker->text(80),
        'actual_price' => $faker->numberBetween(1000, 2500),
        'old_price' => $faker->numberBetween(1000, 2500),
        'description' => $faker->text(100),
        'category_id' => rand(1, 20),
        'stock' => $faker->numberBetween(0, 100),
        'status' => $faker->randomElement(['ACTIVO', 'INACTIVO']),
        'file' => $faker->imageUrl($width = 500, $height = 400 ),
    ];
});
