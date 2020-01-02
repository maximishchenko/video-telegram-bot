<?php


namespace App\Console\Commands\User;


use App\Entity\User;
use Illuminate\Console\Command;

class RoleCommand extends Command
{
    protected $signature = 'user:role';

    protected $description = 'Set role for user';

    public function handle(): bool
    {
        $username = $this->ask(trans('messages.command_user_verify_get_username'));
        $role = $this->ask(trans('messages.command_user_verify_get_role'));

        if (!$user = User::where('username', $username)->first()) {
            $this->error(trans('roles.user_not_found', ['username' => $username]));
            return false;
        }

        try {
            $user->changeRole($role);
        } catch (\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }

        $this->info(trans('roles.role_successfully_changed'));
        return true;
    }
}
