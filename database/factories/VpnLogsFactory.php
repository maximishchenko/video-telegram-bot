<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entity\VpnLog;
use App\Entity\VpnUsers;
use App\Shared;
use Faker\Generator as Faker;

$factory->define(VpnLog::class, function (Faker $faker) {
    $commonNamesArray = VpnUsers::where('status',Shared::STATUS_ACTIVE)->pluck('login')->toArray();
    $eventsArray = array_keys(Shared::getEventsArray());
    $event = $faker->randomElement($eventsArray);

    $request_ip = ($event == Shared::CLIENT_CONNECT) ? $faker->localIpv4 : null;
    $remote_ip = ($event == Shared::CLIENT_CONNECT) ? $faker->ipv4 : null;
    return [
        'common_name' => $faker->randomElement($commonNamesArray),
        'event' => $event,
        'remote_ip' => $request_ip,
        'request_ip' => $remote_ip
    ];
});
