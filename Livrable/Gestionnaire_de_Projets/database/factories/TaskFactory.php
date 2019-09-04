<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
      'title' =>$faker->realText($maxNbChars = 20),
      'limitDate' =>$faker->date($format = 'd-m-Y', $max = 'now'),
      'state' =>  $faker->randomElement(['IN_PROGRESS','FINISHED','VALIDATED']),
      'progress' =>  $faker->numberBetween($min = 0, $max = 100) ,
      'priority' =>  $faker->numberBetween($min = 1, $max = 4) ,
      'comment' =>  $faker->text,
      'project_id' => random_int(1, App\Project::count())
    ];
  });
