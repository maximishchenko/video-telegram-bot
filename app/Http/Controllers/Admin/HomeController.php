<?php

namespace App\Http\Controllers\Admin;

use App\Entity\VpnLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $coordinates = DB::table('vpn_logs')
            ->select('city','latitude','longitude')
            ->where([
                ['latitude', '<>', ''],
                ['longitude', '<>', '']
            ])
            ->get()->toArray();
//        $coordinates = VpnLog::where([
//                ['latitude', '<>', ''],
//                ['longitude', '<>', '']
//            ])->get()->pluck('latitude','longitude');

        return view('admin.home', compact('coordinates'));
    }
}
