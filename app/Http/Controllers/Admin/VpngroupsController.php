<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Crud;
use App\Entity\VpnGroups;
use App\Http\Requests\Admin\VpnGroups\CreateRequest;
use App\Http\Requests\Admin\VpnGroups\UpdateRequest;
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

        Crud::searchEquals($request, $query, 'id');
        Crud::searchLike($request, $query, 'name');
        Crud::searchEquals($request, $query, 'status');
        $groups = Crud::getPageSize($request, $query);

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
        return redirect()->route('admin.vpngroups.show', $group)->with('success', trans('messages.record_added'));
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
        return redirect()->route('admin.vpngroups.show', $group)->with('info', trans('messages.record_updated'));
    }

    public function destroy($id)
    {
        $group = VpnGroups::findOrFail($id);
        $group->delete();
        return redirect()->route('admin.vpngroups.index')->with('error', trans('messages.record_deleted'));
    }


    public function changeStatus($id)
    {
        $group = VpnGroups::findOrFail($id);
        $group->checkGroupAccess();
        if($group->isActive()) {
            $group->block();
            $status = 'error';
            $message = trans('messages.vpngroup_blocked');
        } elseif($group->isBlocked()) {
            $group->activate();
            $status = 'success';
            $message = trans('messages.vpngroup_activated');
        }
        return redirect()->route('admin.vpngroups.show', $group)->with($status, $message);
    }
}
