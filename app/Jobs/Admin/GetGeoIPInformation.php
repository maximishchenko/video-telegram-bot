<?php

namespace App\Jobs\Admin;

use App\Entity\VpnLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetGeoIPInformation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $log;

    public function __construct(VpnLog $log)
    {
        $this->log = $log;
    }

    public function handle()
    {
        $this->log->getGeoIP();
    }

}
