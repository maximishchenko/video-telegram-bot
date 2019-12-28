<?php

namespace App\Http\Controllers\Auth;

use App\Mail\Auth\Register\VerifyMail;
use App\Shared;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'sort' => ['integer'],
            'status' => ['integer'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verify_token' => Str::random(),
            'status' => Shared::STATUS_WAIT,
            'sort' => Shared::DEFAULT_SORT,
        ]);

        Mail::to($user->email)->queue(new VerifyMail($user));
        return $user;
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();

        flash(trans('messages.flash_check_email_and_verify_register'))->info();
        return redirect('login');
    }
}
