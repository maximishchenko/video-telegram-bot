<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Entity\VpnGroups;
use App\Shared;
use Faker\Generator as Faker;

$factory->define(VpnGroups::class, function (Faker $faker) {
    $active = $faker->boolean;
    return [
        'name' => $faker->company,
        'status' => $active ? Shared::STATUS_ACTIVE : Shared::STATUS_BLOCKED,
        'comment' => $faker->text,
    ];
});
