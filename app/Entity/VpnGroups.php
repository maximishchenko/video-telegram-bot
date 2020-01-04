<?php

namespace App\Entity;

use App\Shared;
use Illuminate\Database\Eloquent\Model;

class VpnGroups extends Model
{

    protected $table = 'vpn_groups';

    protected $fillable = [
        'name', 'status', 'comment'
    ];

    public static function new(string  $name, string $comment = null)
    {
        return static::create([
            'name' => $name,
            'comment' => $comment,
            'status' => Shared::STATUS_ACTIVE,
        ]);
    }

    public function isActive()
    {
        return $this->status === Shared::STATUS_ACTIVE;
    }


    public function isBlocked()
    {
        return $this->status === Shared::STATUS_BLOCKED;
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

    public function clients()
    {
        return $this->hasMany('\App\Entity\VpnUsers', 'group_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('\App\Entity\User')->withTimestamps();
    }
}
