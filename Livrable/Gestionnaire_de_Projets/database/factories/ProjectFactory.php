<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
      'title' =>$faker->realText($maxNbChars = 15),
      'description' =>$faker->realText($maxNbChars = 20),
      'limitDate' =>$faker->date($format = 'Y-m-d', $max = '2019-09-20'),
      'startDate' =>$faker->date($format = 'Y-m-d', $max = '2019-09-01'),
      'finishDate' =>$faker->date($format = 'Y-m-d', $max = '2019-09-25'),
      'displacement' =>  $faker->boolean,
      'state' =>  $faker->boolean,
      'comment' =>  $faker->realText($maxNbChars = 20),
      'client_id' => random_int(1, App\Client::count()),
      'user_id' => random_int(1, App\User::count()),
    ];
  });
