<?php

namespace App\Entity;

use App\Shared;
use Illuminate\Database\Eloquent\Model;

class VpnLog extends Model
{
    protected $table = 'openvpn_log';

    protected $fillable = [
        'common_name', 'event', 'remote_ip', 'request_ip'
    ];

    public function connected()
    {
        return $this->event === Shared::CLIENT_CONNECT;
    }

    public function disconnected()
    {
        return $this->event === Shared::CLIENT_DISCONNECT;
    }
}
