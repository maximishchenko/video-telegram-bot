<?php

namespace App\Console\Commands\User;

use App\Entity\User;
use App\UseCases\RegisterService;
use Illuminate\Console\Command;

class VerifyCommand extends Command
{

    protected $signature = 'user:verify';

    protected $description = 'User activation command';

    private $service;

    public function __construct(RegisterService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle(): bool
    {
        $username = $this->ask(trans('messages.command_user_verify_get_username'));
        if (!$user = User::where('username', $username)->first()) {
            $this->error(trans('messages.command_user_verify_user_not_found', ['username' => $username]));
            return false;
        }

        try {
            $this->service->verify($user->id);
            $this->info(trans('messages.command_user_verify_success'));
            return true;
        } catch (\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }


    }
}
