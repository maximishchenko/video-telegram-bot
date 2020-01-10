<?php

namespace App\Entity;

use App\Shared;
use Illuminate\Database\Eloquent\Model;

class VpnLog extends Model
{
    protected $table = 'vpn_logs';

    protected $fillable = [
        'common_name', 'name', 'group', 'event', 'remote_ip', 'request_ip', 'bytes_received', 'bytes_sent', 'rdns', 'asn', 'country_name', 'country_code', 'region_name', 'isp', 'region_code', 'city', 'postal_code', 'continent_code', 'latitude', 'longitude', 'metro_code', 'timezone', 'datetime'
    ];

    public function connected()
    {
        return $this->event === Shared::CLIENT_CONNECT;
    }

    public function disconnected()
    {
        return $this->event === Shared::CLIENT_DISCONNECT;
    }

    public function loginIncorrect()
    {
        return $this->event === Shared::CLIENT_LOGIN_NOT_FOUND;
    }

    public function loginBlocked()
    {
        return $this->event === Shared::CLIENT_BLOCKED;
    }

    public function groupBlocked()
    {
        return $this->event === Shared::CLIENT_GROUP_BLOCKED;
    }

    public function passwordError()
    {
        return $this->event === Shared::CLIENT_PASSWORD_ERROR;
    }

    public function vpnuser()
    {
        return $this->hasOne('App\Entity\VpnUsers', 'login', 'common_name');
    }

    public function vpngroup()
    {
        return $this->hasOne('App\Entity\VpnGroups', 'id', 'group_id');
    }
}
