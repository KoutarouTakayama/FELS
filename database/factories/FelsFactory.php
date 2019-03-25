<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'avatar_url' => 'default.jpg',
        'email_verified_at' => now(),
        'password' => Hash::make('123456'),
        'admin' => false,
    ];
});

$factory->define(App\Relationship::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 10),
        'following_id' => rand(1, 10)
    ];
});

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->text,
    ];
});

$factory->define(App\Word::class, function (Faker $faker) {
    return [
        'word' => $faker->name,
        'answer' => $faker->name,
        'wrong_answer_1' => $faker->name,
        'wrong_answer_2' => $faker->name,
        'wrong_answer_3' => $faker->name,
        'category_id' => rand(1, 10)
    ];
});

$factory->define(App\LearnedLesson::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 10),
        'category_id' => rand(1, 10),
    ];
});

$factory->define(App\LearnedWord::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 10),
        'word_id' => rand(1, 500),
        'correct' => rand(0, 1),
    ];
});
