<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entity\VpnGroups;
use App\Entity\VpnUsers;
use App\Shared;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(VpnUsers::class, function (Faker $faker) {
    $password = Str::random(8);
    $active = $faker->boolean;
    $groups = VpnGroups::where('status',Shared::STATUS_ACTIVE)->pluck('id')->toArray();
    return [
        'name' => $faker->name,
        'login' => $faker->unique()->userName,
        'password_plain' => $password,
        'password_hash' => md5($password),
        'status' => $active ? Shared::STATUS_ACTIVE : Shared::STATUS_BLOCKED,
        'comment' => $faker->text,
        'group_id' => $faker->randomElement($groups),
    ];
});
