<?php

namespace App\Entity;

use App\Shared;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'status', 'sort', 'password', 'username', 'verify_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function register(string $name, string $username, string $email, string $password): self
    {
        return static::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => bcrypt($password),
            'verify_token' => Str::random(),
            'sort' => Shared::DEFAULT_SORT,
            'status' => Shared::STATUS_WAIT
        ]);
    }

    public static function new(string $name, string $username, string $email): self
    {
        return static::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => bcrypt(Str::random()),
            'sort' => Shared::DEFAULT_SORT,
            'status' => Shared::STATUS_ACTIVE
        ]);
    }

    public function isWait(): bool
    {
        return $this->status === Shared::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === Shared::STATUS_ACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this->status === Shared::STATUS_BLOCKED;
    }

    public function verify(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException(trans('messages.user_is_already_verified'));
        }

        $this->update([
            'status' => Shared::STATUS_ACTIVE,
            'verify_token' => null,
        ]);
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

    public function changeStatusConfirmMessage(): string
    {
        return $this->isActive() ? trans('messages.do_block') : trans('messages.do_active');
    }
}
