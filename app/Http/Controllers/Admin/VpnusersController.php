<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Crud;
use App\Entity\VpnGroups;
use App\Entity\VpnLog;
use App\Entity\VpnUsers;
use App\Http\Requests\Admin\VpnUsers\CreateRequest;
use App\Http\Requests\Admin\VpnUsers\PasswordRequest;
use App\Shared;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VpnusersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin')->only('destroy');
    }

    public function index(Request $request)
    {
        if (Auth::user()->can('admin')) {
            $query = VpnUsers::orderBy('id', 'desc');
            $groups = VpnGroups::orderBy('name', 'ASC')->pluck('id','name')->toArray();
        } else {
            $groupIds = Auth::user()->vpngroups()->allRelatedIds()->toArray();
            if (empty($groupIds)) {
                abort(403);
            }
            $query = VpnUsers::whereIn('group_id', $groupIds)->orderBy('id', 'desc');
            $groups = VpnGroups::whereIn('id', $groupIds)->orderBy('name', 'ASC')->pluck('id','name')->toArray();
        }

        Crud::searchEquals($request, $query, 'id');
        Crud::searchEquals($request, $query, 'group_id');
        Crud::searchLike($request, $query, 'name');
        Crud::searchLike($request, $query, 'login');
        Crud::searchEquals($request, $query, 'status');

        $users = Crud::getPageSize($request, $query);
        return view('admin.vpnusers.index', compact('users', 'groups'));
    }

    public function status(Request $request)
    {
        if (Auth::user()->can('admin')) {
            $query = VpnUsers::orderBy('id', 'desc');
            $groups = VpnGroups::orderBy('name', 'ASC')->pluck('id','name')->toArray();
        } else {
            $groupIds = Auth::user()->vpngroups()->allRelatedIds()->toArray();
            if (empty($groupIds)) {
                abort(403);
            }
            $query = VpnUsers::whereIn('group_id', $groupIds)->orderBy('id', 'desc');
            $groups = VpnGroups::whereIn('id', $groupIds)->orderBy('name', 'ASC')->pluck('id','name')->toArray();
        }

        Crud::searchEquals($request, $query, 'id');
        Crud::searchEquals($request, $query, 'group_id');
        Crud::searchLike($request, $query, 'name');
        Crud::searchLike($request, $query, 'login');
        Crud::searchEquals($request, $query, 'connect_status');
        $users = Crud::getPageSize($request, $query);
        return view('admin.vpnusers.status', compact('users', 'groups'));
    }

    public function create()
    {
        if (Auth::user()->can('admin')) {
            $groups = VpnGroups::orderBy('name', 'ASC')->where('status', '=', Shared::STATUS_ACTIVE)->get();
        } else {
            $groupIds = Auth::user()->vpngroups()->allRelatedIds()->toArray();
            if (empty($groupIds)) {
                abort(403);
            }
            $groups = VpnGroups::whereIn('id', $groupIds)->orderBy('name', 'ASC')->where('status', '=', Shared::STATUS_ACTIVE)->get();
        }

        return view('admin.vpnusers.create', compact('groups'));
    }

    public function store(CreateRequest $request)
    {
        $user = VpnUsers::new(
            $request['name'],
            $request['login'],
            $request['group_id'],
            $request['comment']
        );
        return redirect()->route('admin.vpnusers.show', $user);
    }

    public function show($id)
    {
        $user = VpnUsers::findOrFail($id);
        $user->checkClientAccess();
        $lastLog = VpnLog::where([
            ['common_name', $user->login],
            ['event', Shared::CLIENT_CONNECT]
        ])->latest()->first();
        return view('admin.vpnusers.show', compact('user', 'lastLog'));
    }

    public function edit($id)
    {
        $user = VpnUsers::findOrFail($id);
        $user->checkClientAccess();
        return view('admin.vpnusers.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = VpnUsers::findOrFail($id);
        $user->checkClientAccess();
        $user->update($request->only(['name', 'comment']));
        return redirect()->route('admin.vpnusers.show', $user);
    }

    public function destroy($id)
    {
        $user = VpnUsers::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.vpnusers.index');
    }

    public function changeStatus($id)
    {
        $user = VpnUsers::findOrFail($id);
        $user->checkClientAccess();
        if($user->isActive()) {
            $user->block();
        } elseif($user->isBlocked()) {
            $user->activate();
        }
        return redirect()->route('admin.vpnusers.show', $user);
    }

    public function password(VpnUsers $user)
    {
        $user->checkClientAccess();
        return view('admin.vpnusers.password', compact('user'));
    }

    public function setpassword(PasswordRequest $request, VpnUsers $user)
    {
        $user->checkClientAccess();
        $user = $user->changePassword(
            $request['password_plain']
        );
        return redirect()->route('admin.vpnusers.show', $user);
    }
}
