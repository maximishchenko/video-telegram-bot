<?php

namespace App\Http\Controllers\Api;

use App\Entity\VpnLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function trafficSummary()
    {
        $traffic = DB::table('vpn_logs')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(bytes_received) as bytes_received'),
                DB::raw('SUM(bytes_sent) as bytes_sent')
            )
            ->where([
                ['bytes_received', '<>', ''],
                ['bytes_sent', '<>', ''],
                ['created_at', '>=', Carbon::today()->subDays(30)]
            ])
            ->groupBy('date')
            ->get()->toArray();
        return $traffic;
    }

    public function trafficClient()
    {
        $traffic = DB::table('vpn_logs')
            ->select(
                DB::raw('common_name'),
                DB::raw('SUM(bytes_received) as bytes_received'),
                DB::raw('SUM(bytes_sent) as bytes_sent')
            )
            ->where([
                ['bytes_received', '<>', ''],
                ['bytes_sent', '<>', ''],
                ['created_at', '>=', Carbon::today()->subDays(30)]
            ])
            ->groupBy('common_name')
            ->get()->toArray();
        return $traffic;
    }

    public function traficSourcesMap()
    {

        $coordinates = DB::table('vpn_logs')
            ->select('latitude','longitude')
            ->where([
                ['latitude', '<>', ''],
                ['longitude', '<>', '']
            ])
            ->get()->toArray();
        return $coordinates;
    }
}
