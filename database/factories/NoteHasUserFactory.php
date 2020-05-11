<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\NoteHasUser;
use Faker\Generator as Faker;

$factory->define(NoteHasUser::class, function (Faker $faker) {
    return [
        'note_id' => \App\Note::all()->random()->id,
        'status_id' => \App\Status::all()->random()->id,
        'user_id' => \App\User::all()->random()->id,
        'created_at' => $faker->dateTimeThisDecade('now', null),
        'updated_at' => $faker->dateTimeThisDecade('now', null)
    ];
});
