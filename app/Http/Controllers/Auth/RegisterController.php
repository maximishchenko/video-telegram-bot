<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\Auth\Register\VerifyMail;
use App\Shared;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\UseCases\RegisterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    private $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $this->service->register($request);

        flash(trans('messages.flash_check_email_and_verify_register'))->success();
        return redirect()->route('login');
    }

    public function verify($token)
    {
        if(!$user = User::where('verify_token', $token)->first()) {
            flash(trans('messages.flash_link_not_identified'))->error();
            return redirect()->route('login');
        }

        try {
            $this->service->verify($user->id);
            flash(trans('messages.flash_email_verified_do_login'))->success();
            return redirect()->route('login');
        } catch (\DomainException $e) {
            flash($e->getMessage())->error();
            return redirect()->route('login');
        }
    }
}
