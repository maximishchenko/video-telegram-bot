<?php

namespace App\Console\Commands\User;

use App\Entity\User;
use App\Http\Requests\Admin\Users\CreateRequest;
use App\Shared;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RegisterCommand extends Command
{
    protected $signature = 'user:register';

    protected $description = 'Register new user';

    public function handle()
    {
        $name = $this->ask(trans('messages.command_user_register_get_name'));
        $username = $this->ask(trans('messages.command_user_register_get_username'));
        $email = $this->ask(trans('messages.command_user_register_get_email'));
        $phone = $this->ask(trans('messages.command_user_register_get_phone'));

        $password = Str::random();
        $user = User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'password' => bcrypt($password),
            'status' => Shared::STATUS_ACTIVE,
            'role' => Shared::ROLE_USER,
        ]);

        $this->info(trans('messages.command_user_register_new_password', ['password' => $password]));
    }
}
