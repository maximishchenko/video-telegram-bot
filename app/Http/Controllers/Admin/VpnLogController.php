<?php

namespace App\Http\Controllers\Admin;

use App\Entity\VpnGroups;
use App\Entity\VpnLog;
use App\Entity\VpnUsers;
use App\Shared;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VpnLogController extends Controller
{
    public function index(Request $request)
    {
        $query = VpnLog::orderBy('id', 'desc');
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
