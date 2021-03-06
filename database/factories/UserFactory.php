<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Entity\User;
use App\Shared;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


$factory->define(User::class, function (Faker $faker) {
    $active = $faker->boolean;
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->username,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->phoneNumber,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => !$active ? Str::random(10) : null,
        'status' => $active ? Shared::STATUS_ACTIVE : Shared::STATUS_WAIT,
        'role' => $active ? $faker->randomElement(array_keys(Shared::getRolesArray())) : Shared::ROLE_USER,
    ];
});
