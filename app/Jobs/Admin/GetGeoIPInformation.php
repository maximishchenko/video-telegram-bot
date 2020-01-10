<?php

namespace App\Jobs\Admin;

use App\Entity\VpnLog;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetGeoIPInformation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $geo_api_url = 'https://tools.keycdn.com';

    protected $log;

    public function __construct(VpnLog $log)
    {
        $this->log = $log;
    }

    public function handle()
    {
        if (isset($this->log->request_ip) && !empty($this->log->request_ip)) {

            if($this->checkLocalIp($this->log->request_ip)) {
                $client = new Client([
                    'base_uri' => $this->geo_api_url,
                ]);
                $response = $client->request('GET', '/geo.json', [
                    'query' => [
                        'host' => $this->log->request_ip,
                    ],
                    'verify' => false,
                ]);
                if($response->getStatusCode() == 200) {
                    $body = $response->getBody();
                    $arrBody = json_decode($body);
                    if ($arrBody->data->geo->asn) {
                        DB::table('vpn_logs')
                            ->where('id', $this->log->id)
                            ->update([
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
                        Log::info(dd($arrBody));
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

    protected function checkLocalIp($ip)
    {

        if ( ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) )
        {
            return false;
        }
        return true;
    }
}
