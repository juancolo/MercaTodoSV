<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Constants\OrderStatus;
use App\Entities\Order;
use Faker\Generator as Faker;
use Illuminate\Validation\Rule;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'reference' => $faker->name,
        'user_id' => $faker->numberBetween(1,10),
        'status' =>$faker->randomElement(OrderStatus::STATUSES),
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'email' =>$faker->email,
        'document_type' => $faker->randomElement(['CC', 'CE']),
        'document_number' => $faker->numerify('##########'),
        'mobile' => $faker->numerify('##########'),
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->city,
        'zip' => $faker->numerify('######'),
        'total' => $faker->numberBetween(500, 1000),
        'currency' => 'COP',
        'requestId' => $faker->sentence,
        'processUrl' => $faker->url
        ];
});
