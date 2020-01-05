<?php

namespace App\Http\Controllers\Admin;

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

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('username'))) {
            $query->where('username', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('email'))) {
            $query->where('email', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('phone'))) {
            $query->where('phone', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('role'))) {
            $query->where('role', $value);
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        if (!empty($value = $request->get('pageSize')) && (is_numeric($value))) {
            $users = $query->paginate($value);
        } else {
            $users = $query->paginate(Shared::DEFAULT_PAGINATE);
        }
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
        return redirect()->route('admin.users.show', $user);
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

        return redirect()->route('admin.users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index');
    }

    public function changeStatus(User $user)
    {
        if($user->isActive()) {
            $user->block();
        } elseif($user->isBlocked()) {
            $user->activate();
        } else {
            $user->verify();
        }
        return redirect()->route('admin.users.show', $user);
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
        return redirect()->route('admin.users.show', $user);
    }
}
