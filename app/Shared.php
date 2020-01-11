<?php


namespace App;


class Shared
{
    public const STATUS_ACTIVE = 'active';

    public const STATUS_BLOCKED = 'blocked';

    public const STATUS_WAIT = 'wait';

    public const ROLE_ADMIN = 'admin';

    public const ROLE_USER = 'user';

    public const PAGER_20 = 20;

    public const PAGER_50 = 50;

    public const PAGER_100 = 100;

    public const PROTOCOL_TCP = 'tcp';

    public const PROTOCOL_UDP = 'udp';

    public const CLIENT_CONNECT = 'client-connect';

    public const CLIENT_DISCONNECT = 'client-disconnect';

    public const CLIENT_LOGIN_NOT_FOUND = 'client-login-incorrect';

    public const CLIENT_BLOCKED = 'client-blocked';

    public const CLIENT_GROUP_BLOCKED = 'client-group-blocked';

    public const CLIENT_PASSWORD_ERROR = 'cient-password-error';


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
            static::CLIENT_LOGIN_NOT_FOUND => trans('messages.event_client_login_not_found'),
            static::CLIENT_BLOCKED => trans('messages.event_client_blocked'),
            static::CLIENT_GROUP_BLOCKED => trans('messages.event_client_group_blocked'),
            static::CLIENT_PASSWORD_ERROR => trans('messages.event_client_password_error'),
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

    public static function getProtocolsArray(): array
    {
        return [
            static::PROTOCOL_TCP => trans('messages.protocol_tcp'),
            static::PROTOCOL_UDP => trans('messages.protocol_udp'),
        ];
    }

    public static function getPagersArray() {
        return [
            static::PAGER_20 => 20,
            static::PAGER_50 => 50,
            static::PAGER_100 => 100,
        ];
    }


    public static function checkLocalIp($ip)
    {
        if ( ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) )
        {
            return false;
        }
        return true;
    }

    public static function formatBytes($size){
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 2) . " " . $suffix[$f_base];
    }
}
