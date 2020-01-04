<?php

namespace App\Http\Controllers\Admin;

use App\Entity\VpnGroups;
use App\Entity\VpnLog;
use App\Entity\VpnUsers;
use App\Http\Requests\Admin\VpnUsers\CreateRequest;
use App\Http\Requests\Admin\VpnUsers\PasswordRequest;
use App\Shared;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VpnusersController extends Controller
{
    public function index(Request $request)
    {
        $query = VpnUsers::orderBy('id', 'desc');
        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }
        if (!empty($value = $request->get('group_id'))) {
            $query->where('group_id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('login'))) {
            $query->where('login', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        $groups = VpnGroups::where('status',Shared::STATUS_ACTIVE)->pluck('id','name')->toArray();

        $users = $query->paginate(Shared::DEFAULT_PAGINATE);
        return view('admin.vpnusers.index', compact('users', 'groups'));
    }


    public function create()
    {
        $groups = VpnGroups::all()->where('status', '=', Shared::STATUS_ACTIVE);
        return view('admin.vpnusers.create', compact('groups'));
    }

    public function store(CreateRequest $request)
    {
        $user = VpnUsers::new(
            $request['name'],
            $request['comment'],
            $request['group_id']
        );
        return redirect()->route('admin.vpnusers.show', $user);
    }

    public function show($id)
    {
        $user = VpnUsers::findOrFail($id);
        $lastLog = VpnLog::where([
            ['common_name', $user->login],
            ['event', Shared::CLIENT_CONNECT]
        ])->latest()->first();
        return view('admin.vpnusers.show', compact('user', 'lastLog'));
    }

    public function edit($id)
    {
        $user = VpnUsers::findOrFail($id);
//        $user = $id;
        return view('admin.vpnusers.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = VpnUsers::findOrFail($id);
        $user->update($request->only(['name', 'login', 'comment']));
        return redirect()->route('admin.vpnusers.show', $user);
    }

    public function destroy($id)
    {
        //
    }

    public function changeStatus($id)
    {
        $group = VpnUsers::findOrFail($id);
        if($group->isActive()) {
            $group->block();
        } elseif($group->isBlocked()) {
            $group->activate();
        }
        return redirect()->route('admin.vpnusers.show', $group);
    }

    public function password(VpnUsers $user)
    {
        return view('admin.vpnusers.password', compact('user'));
    }

    public function setpassword(PasswordRequest $request, VpnUsers $user)
    {
        $user = $user->changePassword(
            $request['password_plain']
        );
        return redirect()->route('admin.vpnusers.show', $user);
    }
}
