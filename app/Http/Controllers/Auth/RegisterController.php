<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\Auth\Register\VerifyMail;
use App\Shared;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'verify_token' => Str::random(),
            'status' => Shared::STATUS_WAIT,
        ]);
        Mail::to($user->email)->queue(new VerifyMail($user));
        event(new Registered($user));

        flash(trans('messages.flash_check_email_and_verify_register'))->success();
        return redirect()->route('login');
    }

    public function verify($token)
    {
        if(!$user = User::where('verify_token', $token)->first()) {
            flash(trans('messages.flash_link_not_identified'))->error();
            return redirect()->route('login');
        }
        if($user->status != Shared::STATUS_WAIT) {
            flash(trans('messages.flash_email_allready_verified'))->error();
            return redirect()->route('login');
        }

        $user->status = Shared::STATUS_ACTIVE;
        $user->verify_token = null;
        $user->save();

        flash(trans('messages.flash_email_verified_do_login'))->success();
        return redirect()->route('login');
    }
}
