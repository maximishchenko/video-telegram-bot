<?php

namespace App\Entity;

use App\Shared;
use Illuminate\Database\Eloquent\Model;

class VpnLog extends Model
{
    protected $table = 'vpn_logs';

    protected $fillable = [
        'common_name', 'name', 'group', 'event', 'remote_ip', 'request_ip', 'bytes_received', 'bytes_sent'
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

    public function getFullName()
    {
        $name = (isset($this->name) && $this->name !== 'null') ? '(' . $this->name . ',' : null;
        $group = (isset($this->group) && $this->group !== 'null') ? $this->group . ')' : null;
        return $this->common_name . ' ' . $name . ' ' . $group;
    }

    public function getIpAddresses()
    {
        $remote_ip = (isset($this->remote_ip) && $this->remote_ip !== 'null') ? $this->remote_ip : null;
        $request_ip = (isset($this->request_ip) && $this->request_ip !== 'null') ? $this->request_ip : null;
        return $request_ip . ' ' . $remote_ip;
    }

    public function getBytesCount()
    {
        $bytes_received = (isset($this->bytes_received) && $this->bytes_received !== 'null') ? $this->bytes_received: null;
        $bytes_sent = (isset($this->bytes_sent) && $this->bytes_sent !== 'null') ? $this->bytes_sent: null;

        return ($bytes_sent !== null && $bytes_received !== null) ? $bytes_sent . ' | ' . $bytes_received : null;
    }
}
