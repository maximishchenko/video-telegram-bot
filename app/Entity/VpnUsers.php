<?php

namespace App\Entity;

use App\Shared;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class VpnUsers extends Model
{

    protected $table = 'vpn_users';

    protected $fillable = [
        'name', 'login', 'status', 'comment', 'password_hash', 'password_plain', 'group_id', 'connect_status'
    ];

    public static function new(string  $name, string $login, int $group_id, string $comment = null)
    {
        $password = Str::random(8);
        return static::create([
            'name' => $name,
            'comment' => $comment,
            'login' => $login,
            'password_hash' => md5($password),
            'password_plain' => $password,
            'group_id' => $group_id,
            'status' => Shared::STATUS_ACTIVE,
            'connect_status' => Shared::CLIENT_DISCONNECTED
        ]);
    }

    public function isActive()
    {
        return ($this->status === Shared::STATUS_ACTIVE && $this->group->status === Shared::STATUS_ACTIVE);
    }


    public function isBlocked()
    {
        return $this->status === Shared::STATUS_BLOCKED;
    }

    public function isConnected()
    {
        return ($this->connect_status === Shared::CLIENT_CONNECTED);
    }


    public function isDisconnected()
    {
        return $this->connect_status === Shared::CLIENT_DISCONNECTED;
    }

    public function changeStatusConfirmMessage(): string
    {
        return $this->isActive() ? trans('messages.do_block') : trans('messages.do_active');
    }

    public function changeStatusButtonText(): string
    {
        return $this->isActive() ? trans('messages.admin_user_btn_block') : trans('messages.admin_user_btn_active');
    }

    public function block(): void
    {
        self::update([
            'status' => Shared::STATUS_BLOCKED,
        ]);
    }

    public function activate(): void
    {
        self::update([
            'status' => Shared::STATUS_ACTIVE,
        ]);
    }

    public function changePassword(string $password)
    {
        return $this->update([
            'password_plain' => $password,
            'password_hash' => md5($password)
        ]);
    }

    public function group()
    {
        return $this->hasOne('App\Entity\VpnGroups', 'id', 'group_id');
    }

    public function checkClientAccess()
    {
        if (Gate::denies('client_access', $this)) {
            abort(403);
        }
    }
}
