<?php

namespace App\Console\Commands\Vpn;

use App\Entity\VpnGroups;
use App\Entity\VpnLog;
use App\Entity\VpnUsers;
use App\Shared;
use Illuminate\Console\Command;

class LogAppendCommand extends Command
{
    protected $signature = 'log:append {common_name} {event} {remote_ip=null} {request_ip=null}';

    protected $description = 'Connect log';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $common_name = $this->argument('common_name');
        $event = $this->argument('event');
        $remote_ip = $this->argument('remote_ip');
        $request_ip = $this->argument('request_ip');

        $user = VpnUsers::where('login',$common_name)->first();
        $group = VpnGroups::where('id',$user->group_id)->first();

        $log = VpnLog::create([
            'common_name' => $common_name,
            'name' => $user->name,
            'event' => $event,
            'group' => $group->name,
            'remote_ip' => $remote_ip,
            'request_ip' => $request_ip
        ]);

        $client = VpnUsers::where('login', $common_name)->first();
        if ($client) {
            if ($event == Shared::CLIENT_CONNECT) {
                $client->connect_status = Shared::CLIENT_CONNECTED;
            } elseif ($event == Shared::CLIENT_DISCONNECT) {
                $client->connect_status = Shared::CLIENT_DISCONNECTED;
            }
            $client->save();
        }


        $this->info('Log record was added');
    }
}
