<?php


namespace App;


class Shared
{
    public const STATUS_ACTIVE = 'active';

    public const STATUS_BLOCKED = 'blocked';

    public const STATUS_WAIT = 'wait';

    public const ROLE_ADMIN = 'admin';

    public const ROLE_USER = 'user';

    public const CLIENT_CONNECT = 'client-connect';

    public const CLIENT_DISCONNECT = 'client-disconnect';

    public const CLIENT_CONNECTED = 'connected';

    public const CLIENT_DISCONNECTED = 'disconnected';

    public const DEFAULT_PAGINATE = 50;

    public static function getRolesArray(): array
    {
        return [
            static::ROLE_USER => trans('roles.user'),
            static::ROLE_ADMIN => trans('roles.admin'),
        ];
    }

    public static function getEventsArray(): array
    {
        return [
            static::CLIENT_CONNECT => trans('messages.client_connected'),
            static::CLIENT_DISCONNECT => trans('messages.client_disconnected'),
        ];
    }

    public static function getConnectionStatusesArray(): array
    {
        return [
            static::CLIENT_CONNECTED => trans('messages.status_conneted'),
            static::CLIENT_DISCONNECTED => trans('messages.status_disconnected'),
        ];
    }

    public static function getStatusesArray(): array
    {
        return [
            static::STATUS_ACTIVE => trans('roles.active'),
            static::STATUS_WAIT => trans('roles.wait'),
            static::STATUS_BLOCKED => trans('roles.blocked'),
        ];
    }

    public static function getShortStatusesArray(): array
    {
        return [
            static::STATUS_ACTIVE => trans('roles.active'),
            static::STATUS_BLOCKED => trans('roles.blocked'),
        ];
    }

}
