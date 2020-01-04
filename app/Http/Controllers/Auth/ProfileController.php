<?php

namespace App\Http\Controllers\Auth;

use App\Entity\User;
use App\Http\Requests\Admin\Users\PasswordRequest;
use App\Http\Requests\Profile\UpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Auth::user();
        return view('auth.profile.index', compact('profile'));
    }

    public function password(User $user)
    {
        $user = Auth::user();
        return view('auth.profile.password', compact('user'));
    }

    public function setpassword(PasswordRequest $request, User $user)
    {
        $user = $user->changePassword(
            $request['password']
        );
        return redirect()->route('admin.profile.index', $user);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('auth.profile.edit', compact('user'));
    }

    public function update(UpdateRequest $request)
    {
        $user = Auth::user();
        $user->update($request->only(['name', 'email', 'phone']));
        return redirect()->route('profile', $user);
    }
}
