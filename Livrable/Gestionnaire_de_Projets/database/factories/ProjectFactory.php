<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
      'title' =>$faker->realText($maxNbChars = 15),
      'description' =>$faker->realText($maxNbChars = 20),
      'limitDate' =>$faker->date($format = 'd-m-Y', $max = '20-09-2019'),
      'startDate' =>$faker->date($format = 'd-m-Y', $max = '01-09-2019'),
      'finishDate' =>$faker->date($format = 'd-m-Y', $max = '25-09-2019'),
      'displacement' =>  $faker->boolean,
      'state' =>  $faker->boolean,
      'comment' =>  $faker->realText($maxNbChars = 20),
      'client_id' => random_int(1, App\Client::count()),
      'user_id' => random_int(1, App\User::count()),
    ];
  });
