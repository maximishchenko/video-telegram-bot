<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Crud;
use App\Entity\User;
use App\Entity\VpnGroups;
use App\Entity\VpnLog;
use App\Http\Requests\Admin\Users\CreateRequest;
use App\Http\Requests\Admin\Users\PasswordRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Shared;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Generator\StringManipulation\Pass\Pass;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index(Request $request)
    {
        $query = User::orderBy('id', 'desc');

        Crud::searchEquals($request, $query, 'id');
        Crud::searchLike($request, $query, 'name');
        Crud::searchLike($request, $query, 'username');
        Crud::searchLike($request, $query, 'email');
        Crud::searchLike($request, $query, 'phone');
        Crud::searchEquals($request, $query, 'role');
        Crud::searchEquals($request, $query, 'status');

        $users = Crud::getPageSize($request, $query);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(CreateRequest $request)
    {
        $user = User::new(
            $request['name'],
            $request['username'],
            $request['email'],
            $request['phone']
        );
        return redirect()->route('admin.users.show', $user)->with('success', trans('messages.record_added'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $vpngroups = VpnGroups::orderBy('name')->where('status', Shared::STATUS_ACTIVE)->get();
        return view('admin.users.edit', compact('user', 'vpngroups'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->only(['name', 'email', 'status', 'phone', 'role']));
        $user->vpngroups()->sync( $request['vpngroups'] );

        return redirect()->route('admin.users.show', $user)->with('info', trans('messages.record_updated'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('error', trans('messages.record_deleted'));
    }

    public function changeStatus(User $user)
    {
        if($user->isActive()) {
            $user->block();
            $status = 'error';
            $message = trans('messages.user_blocked');
        } elseif($user->isBlocked()) {
            $user->activate();
            $status = 'success';
            $message = trans('messages.user_activated');
        } else {
            $user->verify();
            $status = 'success';
            $message = trans('messages.user_verified');
        }
        return redirect()->route('admin.users.show', $user)->with($status, $message);
    }

    public function password(User $user)
    {
        return view('admin.users.password', compact('user'));
    }

    public function setpassword(PasswordRequest $request, User $user)
    {
        $user = $user->changePassword(
                $request['password']
            );
        return redirect()->route('admin.users.show', $user)->with('info', trans('messages.password_changed'));
    }
}
