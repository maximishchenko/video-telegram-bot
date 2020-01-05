<?php

namespace App\Console\Commands\Vpn;

use App\Entity\VpnGroups;
use App\Entity\VpnLog;
use App\Entity\VpnUsers;
use App\Shared;
use Illuminate\Console\Command;

class AuthCommand extends Command
{

    protected $signature = 'vpn:auth {login} {password}';

    protected $description = 'Check user\'s auth';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $login = $this->argument('login');
        $password = $this->argument('password');

        if (!$user = VpnUsers::where('login', $login)->first()) {
            $this->storeEvent($login, 'null', Shared::CLIENT_LOGIN_NOT_FOUND,'null');
            $this->error(trans('messages.event_client_login_not_found'));
            return false;
        }

        $group = VpnGroups::where('id',$user->group_id)->first();

        if ($user->status == Shared::STATUS_BLOCKED) {
            $this->storeEvent($login, $user->name, Shared::CLIENT_BLOCKED, $group->name);
            $this->error(trans('messages.event_client_blocked'));
            return false;
        }

        if ($group->status == Shared::STATUS_BLOCKED) {
            $this->storeEvent($login, $user->name, Shared::CLIENT_GROUP_BLOCKED, $group->name);
            $this->error(trans('messages.event_client_group_blocked'));
            return false;
        }

        if (md5($password) != $user->password_hash) {
            $this->storeEvent($login, $user->name, Shared::CLIENT_PASSWORD_ERROR, $group->name);
            $this->error(trans('messages.event_client_password_error'));
            return false;
        } else {
            $this->info("success");
            return true;
        }
    }

    private function storeEvent(string $common_name, string $name, string $event, string $group) {

        $log = VpnLog::create([
            'common_name' => $common_name,
            'name' => $name,
            'event' => $event,
            'group' => $group,
            'remote_ip' => 'null',
            'request_ip' => 'null'
        ]);
    }

}
