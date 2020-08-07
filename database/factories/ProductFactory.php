<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
            'name' => $this->faker->firstName,
            'details' => $this->faker->sentence,
            'slug' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(1000,2000),
            'description' => $this->faker->sentence,
            'category' => $this->faker->numberBetween(1-10),
    ];
});
