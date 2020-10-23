<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Order;
use Faker\Generator as Faker;
use Illuminate\Validation\Rule;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'first_name' => [],
        'last_name' => [],
        'email' =>[],
        'document_type' => [],
        'document_number' => [],
        'state' => [],
        'street' => [],
        'zip' => [],
        'mobile' => []
        ];
});
