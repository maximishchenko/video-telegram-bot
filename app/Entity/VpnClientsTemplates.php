<?php

namespace App\Entity;

use App\Shared;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VpnClientsTemplates extends Model
{
    const UPLOAD_PATH = 'crt';

    protected $table = 'vpn_clients_templates';

    protected $fillable = [
        'name', 'protocol', 'host', 'port', 'ca_file', 'cert_file', 'key_file', 'status', 'comment'
    ];

    public static function new(string  $name, string $protocol, string $host, string $port, string $ca_file, string $cert_file, string $key_file, string $comment = null)
    {
        return static::create([
            'name' => $name,
            'protocol' => $protocol,
            'host' => $host,
            'port' => $port,
            'ca_file' => $ca_file,
            'cert_file' => $cert_file,
            'key_file' => $key_file,
            'status' => Shared::STATUS_ACTIVE,
            'comment' => $comment,
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

    public function getCAUrl(): string
    {
        return Storage::disk('public')->url(static::UPLOAD_PATH.'/'.$this->ca_file);
    }

    public function getCertUrl(): string
    {
        return Storage::disk('public')->url(static::UPLOAD_PATH.'/'.$this->cert_file);
    }

    public function getKeyUrl(): string
    {
        return Storage::disk('public')->url(static::UPLOAD_PATH.'/'.$this->key_file);
    }

    public function getServerUri(): string
    {
        return $this->protocol.'://'.$this->host.':'.$this->port;
    }

    public function getCAPath()
    {
        return static::UPLOAD_PATH.'/'.$this->ca_file;
    }

    public function getCertPath()
    {
        return static::UPLOAD_PATH.'/'.$this->cert_file;
    }

    public function getKeyPath()
    {
        return static::UPLOAD_PATH.'/'.$this->key_file;
    }
}
