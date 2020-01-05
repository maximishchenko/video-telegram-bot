<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use App\Entity\VpnGroups;
use App\Http\Requests\Admin\VpnGroups\CreateRequest;
use App\Http\Requests\Admin\VpnGroups\UpdateRequest;
use App\Shared;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VpngroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin')->only('create','store', 'destroy');
    }

    public function index(Request $request)
    {
        if (Auth::user()->can('admin')) {
            $query = VpnGroups::orderBy('id', 'desc');
        } else {
            $records = Auth::user()->vpngroups()->allRelatedIds()->toArray();
            if (empty($records)) {
                abort(403);
            }
            $query = VpnGroups::whereIn('id', $records)->orderBy('id', 'desc');
        }

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }
        $groups = $query->paginate(Shared::DEFAULT_PAGINATE);
        return view('admin.vpngroups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.vpngroups.create');
    }

    public function store(CreateRequest $request)
    {
        $group = VpnGroups::new(
            $request['name'],
            $request['comment']
        );
        return redirect()->route('admin.vpngroups.show', $group);
    }

    public function show($id)
    {
        $group = VpnGroups::findOrFail($id);
        $group->checkGroupAccess();
        return view('admin.vpngroups.show', compact('group'));
    }

    public function edit($id)
    {
        $group = VpnGroups::findOrFail($id);
        $group->checkGroupAccess();
        return view('admin.vpngroups.edit', compact('group'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $group = VpnGroups::findOrFail($id);
        $group->checkGroupAccess();
        $group->update($request->only(['name', 'comment']));
        return redirect()->route('admin.vpngroups.show', $group);
    }

    public function destroy($id)
    {
        $group = VpnGroups::findOrFail($id);
        $group->delete();
        return redirect()->route('admin.vpngroups.index');
    }


    public function changeStatus($id)
    {
        $group = VpnGroups::findOrFail($id);
        $group->checkGroupAccess();
        if($group->isActive()) {
            $group->block();
        } elseif($group->isBlocked()) {
            $group->activate();
        }
        return redirect()->route('admin.vpngroups.show', $group);
    }
}
