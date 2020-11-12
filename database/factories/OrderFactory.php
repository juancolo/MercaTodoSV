<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Order;
use Faker\Generator as Faker;
use Illuminate\Validation\Rule;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'reference' => $faker->name,
        'user_id' => $faker->numberBetween(1,10),
        'status' =>$faker->randomElement(['OK','PENDING', 'FAILED', 'APPROVED', 'APPROVED_PARTIAL','PARTIAL_EXPIRED', 'REJECTED', 'PENDING_VALIDATION', 'REFUNDED' ]),
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'email' =>$faker->email,
        'document_type' => $faker->randomElement(['CC', 'CE']),
        'document_number' => $faker->numerify('##########'),
        'mobile' => $faker->phoneNumber,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->city,
        'zip' => $faker->sentence,
        'total' => $faker->numberBetween(500, 1000),
        'currency' => 'COP',
        'requestId' => $faker->sentence,
        'processUrl' => $faker->url
        ];
});
