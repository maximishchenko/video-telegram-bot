<?php

namespace App\Console\Commands\User;

use App\Entity\VpnUsers;
use App\Shared;
use Illuminate\Console\Command;

class AuthCommand extends Command
{

    protected $signature = 'user:auth {login} {password}';

    protected $description = 'Check user\'s auth';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $login = $this->argument('login');
        $password = $this->argument('password');

        if (!$user = VpnUsers::where([
            ['status', Shared::STATUS_ACTIVE],
            ['login', $login]
        ])->first()) {
            $this->error("error");
            return false;
        }

        if (md5($password) != $user->password_hash) {
            $this->error("error");
            return false;
        } else {
            $this->info("success");
            return true;
        }
    }

}
