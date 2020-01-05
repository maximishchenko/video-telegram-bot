<?php

namespace App\Http\Controllers\Admin;

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

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }
        if (!empty($value = $request->get('common_name'))) {
            $query->where('common_name', 'like', '%' . $value . '%');
        }
        if (!empty($value = $request->get('remote_ip'))) {
            $query->where('remote_ip', 'like', '%' . $value . '%');
        }
        if (!empty($value = $request->get('request_ip'))) {
            $query->where('request_ip', 'like', '%' . $value . '%');
        }
        if (!empty($value = $request->get('event'))) {
            $query->where('event', $value);
        }

        $logs = $query->paginate(Shared::DEFAULT_PAGINATE);
        return view('admin.vpnlogs.index', compact('logs'));
    }
}
