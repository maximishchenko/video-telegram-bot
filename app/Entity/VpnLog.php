<?php

namespace App\Entity;

use App\Shared;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    public function getGeoIP()
    {
        if (isset($this->request_ip) && !empty($this->request_ip)) {

            if(Shared::checkLocalIp($this->request_ip)) {
                $client = new Client([
                    'base_uri' => 'https://tools.keycdn.com',
                ]);
                $response = $client->request('GET', '/geo.json', [
                    'query' => [
                        'host' => $this->request_ip,
                    ],
                    'verify' => false,
                ]);
                if($response->getStatusCode() == 200) {
                    $body = $response->getBody();
                    $arrBody = json_decode($body);
                    if ($arrBody->data->geo->rdns) {
                        $this->update([
                            'rdns' => $arrBody->data->geo->rdns,
                            'asn' => $arrBody->data->geo->asn,
                            'isp' => $arrBody->data->geo->isp,
                            'country_name' => $arrBody->data->geo->country_name,
                            'country_code' => $arrBody->data->geo->country_code,
                            'region_name' => $arrBody->data->geo->region_name,
                            'region_code' => $arrBody->data->geo->region_code,
                            'city' => $arrBody->data->geo->city,
                            'postal_code' => $arrBody->data->geo->postal_code,
                            'continent_code' => $arrBody->data->geo->continent_code,
                            'latitude' => $arrBody->data->geo->latitude,
                            'longitude' => $arrBody->data->geo->longitude,
                            'metro_code' => $arrBody->data->geo->metro_code,
                            'timezone' => $arrBody->data->geo->timezone,
                            'datetime' => $arrBody->data->geo->datetime
                        ]);
                        Log::info(print_r($arrBody));
                    } else {
                        Log::error('empty_data');
                    }
                }
            } else {
                Log::error('local_ip');
            }
        }
        else {
            Log::error('empty ip');
        }
    }
}
