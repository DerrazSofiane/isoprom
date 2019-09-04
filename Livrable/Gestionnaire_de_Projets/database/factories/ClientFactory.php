<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
      'registrationNumber' =>$faker->numberBetween($min = 10000, $max = 90000),
      'name' =>$faker->name,
      'email' =>$faker->email,
      'address' =>$faker->address,
      'phoneNumber' =>$faker->e164PhoneNumber,
      'comment' =>  $faker->realText($maxNbChars = 20),
    ];
  });
