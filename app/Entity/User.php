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
        'name', 'email', 'status', 'password', 'username', 'verify_token', 'role', 'phone'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function register(string $name, string $username, string $email, string $phone, string $password): self
    {
        return static::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'password' => bcrypt($password),
            'verify_token' => Str::random(),
            'status' => Shared::STATUS_ACTIVE,
            'role' => Shared::ROLE_USER,
        ]);
    }

    public static function new(string $name, string $username, string $email, string $phone): self
    {
        return static::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'password' => bcrypt(Str::random()),
            'status' => Shared::STATUS_ACTIVE,
            'role' => Shared::ROLE_USER,
        ]);
    }

    public function changePassword(string $password)
    {
        return $this->update([
            'password' => bcrypt($password)
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

    public function isAdmin(): bool
    {
        return $this->role === Shared::ROLE_ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role === Shared::ROLE_USER;
    }

    public function isManager(): bool
    {
        return $this->role === Shared::ROLE_MANAGER;
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

    public function changeStatusButtonText(): string
    {
        return $this->isActive() ? trans('messages.admin_user_btn_block') : trans('messages.admin_user_btn_active');
    }

    public function changeRole($role): void
    {
        if(!\in_array($role, array_keys(Shared::getRolesArray()))) {
            throw new \InvalidArgumentException('Undefined role "' . $role . '"');
        }
        if ($this->role === $role) {
            throw new \DomainException('Role is already assigned.');
        }
        $this->update(['role' => $role]);
    }
}
