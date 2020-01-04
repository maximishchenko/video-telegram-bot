<?php

namespace App\Console\Commands\Vpn;

use App\Entity\VpnLog;
use Illuminate\Console\Command;

class LogConnectCommand extends Command
{
    protected $signature = 'log:connect {common_name} {event} {remote_ip} {request_ip}';

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

        $log = VpnLog::create([
            'common_name' => $common_name,
            'event' => $event,
            'remote_ip' => $remote_ip,
            'request_ip' => $request_ip
        ]);

        $this->info('Log record was added');
    }
}
