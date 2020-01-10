<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Crud;
use App\Entity\VpnGroups;
use App\Entity\VpnLog;
use App\Entity\VpnUsers;
use App\Shared;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VpnLogController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->can('admin')) {
            $query = VpnLog::orderBy('id', 'desc');
        } else {
            $groupIds = Auth::user()->vpngroups()->allRelatedIds()->toArray();
            if (empty($groupIds)) {
                abort(403);
            }
            $groupNames = VpnGroups::whereIn('id', $groupIds)->orderBy('name', 'ASC')->pluck('name')->toArray();
            $query = VpnLog::whereIn('group', $groupNames);
        }

        Crud::searchEquals($request, $query, 'id');
        Crud::searchLike($request, $query, 'common_name');
        Crud::searchLike($request, $query, 'remote_ip');
        Crud::searchLike($request, $query, 'request_ip');
        Crud::searchEquals($request, $query, 'event');

        $logs = Crud::getPageSize($request, $query);
        return view('admin.vpnlogs.index', compact('logs'));
    }

    public function show($id)
    {
        $log = VpnLog::findOrFail($id);
        return view('admin.vpnlogs.show', compact('log'));
    }
}
