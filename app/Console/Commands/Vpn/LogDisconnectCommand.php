<?php

namespace App\Console\Commands\Vpn;

use App\Entity\VpnLog;
use Illuminate\Console\Command;

class LogDisconnectCommand extends Command
{
    protected $signature = 'log:disconnect {common_name} {event}';

    protected $description = 'Connect log';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $common_name = $this->argument('common_name');
        $event = $this->argument('event');

        $log = VpnLog::create([
            'common_name' => $common_name,
            'event' => $event,
            'remote_ip' => null,
            'request_ip' => null
        ]);

        $this->info('Log record was added');
    }
}
