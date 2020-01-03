<?php


namespace App\UseCases;


use App\Entity\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\Auth\Register\VerifyMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;

class RegisterService
{
    private $mailer;

    private $dispatcher;

    public function __construct(Mailer $mailer, Dispatcher $dispatcher)
    {
        $this->mailer = $mailer;
        $this->dispatcher = $dispatcher;
    }

    public function register(RegisterRequest $request): void
    {
        $user = User::register(
            $request['name'],
            $request['username'],
            $request['email'],
            $request['phone'],
            $request['password']
        );

//        $this->mailer->to($user->email)->send(new VerifyMail($user));
        $this->dispatcher->dispatch(new Registered($user));
    }

    public function verify($id): void
    {
        $user = User::findOrFail($id);
        $user->verify();
    }
}