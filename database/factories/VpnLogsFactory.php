<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entity\VpnGroups;
use App\Entity\VpnLog;
use App\Entity\VpnUsers;
use App\Shared;
use Faker\Generator as Faker;

$factory->define(VpnLog::class, function (Faker $faker) {
    $commonNamesArray = VpnUsers::where('status',Shared::STATUS_ACTIVE)->pluck('login')->toArray();
    $common_name = $faker->randomElement($commonNamesArray);
    $user_id = VpnUsers::where('login',$common_name)->first();
    $group = VpnGroups::where('id',$user_id->group_id)->first();

    $eventsArray = [Shared::CLIENT_CONNECT, Shared::CLIENT_DISCONNECT];
    $event = $faker->randomElement($eventsArray);

    $request_ip = ($event == Shared::CLIENT_CONNECT) ? $faker->localIpv4 : null;
    $remote_ip = ($event == Shared::CLIENT_CONNECT) ? $faker->ipv4 : null;
    return [
        'common_name' => $common_name,
        'name' => $user_id->name,
        'event' => $event,
        'group' => $group->name,
        'remote_ip' => $request_ip,
        'request_ip' => $remote_ip
    ];
});
