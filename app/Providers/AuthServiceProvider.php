<?php

namespace App\Providers;

use App\Entity\User;
use App\Entity\VpnGroups;
use App\Entity\VpnUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function(User $user) {
            return $user->isAdmin();
        });

        Gate::define('group_access', function(User $user, VpnGroups $group) {
            $userGroups = Auth::user()->vpngroups()->allRelatedIds()->toArray();
            if ($user->isAdmin()) {
                return true;
            }
            if (in_array($group->id, $userGroups)) {
                return true;
            }
            return false;
        });

        Gate::define('client_access', function(User $user, VpnUsers $client) {
            $userGroups = Auth::user()->vpngroups()->allRelatedIds()->toArray();
            if ($user->isAdmin()) {
                return true;
            }
            if (in_array($client->group_id, $userGroups)) {
                return true;
            }
            return false;
        });

        Gate::define('config_edit', function(User $user) {
            return $user->isAdmin();
        });

        Gate::define('display_clients', function(User $user) {
            $userGroups = Auth::user()->vpngroups()->allRelatedIds()->toArray();
            if ($user->isAdmin()) {
                return true;
            }
            if (!empty($userGroups)) {
                return true;
            }
            return false;
        });
    }
}
