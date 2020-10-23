<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Tag;
use App\Entities\Model;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
    'name' => $faker->name(),
    ];
});
