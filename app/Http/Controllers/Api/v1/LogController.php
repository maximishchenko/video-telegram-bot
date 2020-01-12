<?php

namespace App\Http\Controllers\Api\v1;

use App\Entity\VpnLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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

    public function eventsCalendar()
    {
        $start = $id = Input::get('start');
        $end = $id = Input::get('end');
        $events = DB::table('vpn_logs')
            ->select(
                DB::raw('created_at as start'),
                DB::raw('created_at as end'),
                DB::raw('common_name as title'),
                DB::raw('event as event'),
//                DB::raw('(CASE
//                    WHEN (event = "client-connect") THEN "green"
//                    WHEN (event = "client-disconnect") THEN "orange"
//                    ELSE "red" END) as color'
//                ),
                DB::raw('id as id')
            )
            ->whereBetween('created_at', [$start, $end])
            ->get()->toArray();
        return $events;
    }
}
