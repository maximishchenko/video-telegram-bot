<?php

use App\Entity\User;
use App\Entity\VpnClientsTemplates;
use App\Entity\VpnGroups;
use App\Entity\VpnUsers;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('home', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->push(trans('messages.breadcrumbs_homelink'), route('home'));
});

Breadcrumbs::register('login', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push(trans('messages.breadcrumbs_login'), route('login'));
});

Breadcrumbs::register('password.request', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('login');
    $crumbs->push(trans('messages.breadcrumbs_resetpwd'), route('password.request'));
});

Breadcrumbs::register('register', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push(trans('messages.breadcrumbs_register'), route('register'));
});

Breadcrumbs::register('password.reset', function (BreadcrumbsGenerator $crumbs, $token) {
    $crumbs->parent('login');
    $crumbs->push(trans('messages.breadcrumbs_newpwd'), route('password.request', ['token' => $token]));
});

Breadcrumbs::register('profile', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push(trans('messages.breadcrumbs_profile'), route('profile'));
});
Breadcrumbs::register('profile.password', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('profile');
    $crumbs->push(trans('messages.admin_btn_password'), route('profile.password'));
});
Breadcrumbs::register('profile.update', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('profile');
    $crumbs->push(trans('messages.admin_btn_password'), route('profile.update'));
});
Breadcrumbs::register('profile.edit', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('profile');
    $crumbs->push(trans('messages.admin_btn_password'), route('profile.edit'));
});
Breadcrumbs::register('admin.home', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push(trans('messages.breadcrumbs_admin'), route('admin.home'));
});


Breadcrumbs::register('admin.users.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push(trans('messages.breadcrumbs_admin_users'), route('admin.users.index'));
});

Breadcrumbs::register('admin.users.create', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.users.index');
    $crumbs->push(trans('messages.breadcrumbs_admin_users_create'), route('admin.users.create'));
});
Breadcrumbs::register('admin.users.show', function (BreadcrumbsGenerator $crumbs, User $user) {
    $crumbs->parent('admin.users.index');
    $crumbs->push($user->name, route('admin.users.show', $user));
});
Breadcrumbs::register('admin.users.edit', function (BreadcrumbsGenerator $crumbs, User $user) {
    $crumbs->parent('admin.users.show', $user);
    $crumbs->push(trans('messages.breadcrumbs_admin_users_update'), route('admin.users.edit', $user));
});
Breadcrumbs::register('admin.users.password', function (BreadcrumbsGenerator $crumbs, User $user) {
    $crumbs->parent('admin.users.show', $user);
    $crumbs->push(trans('messages.admin_btn_password'), route('admin.users.password', $user));
});


Breadcrumbs::register('admin.vpngroups.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push(trans('messages.vpngroups'), route('admin.vpngroups.index'));
});

Breadcrumbs::register('admin.vpngroups.create', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.vpngroups.index');
    $crumbs->push(trans('messages.breadcrumbs_admin_vpngroups_create'), route('admin.vpngroups.create'));
});
Breadcrumbs::register('admin.vpngroups.show', function (BreadcrumbsGenerator $crumbs, $id) {
    $group = VpnGroups::findOrFail($id);
    $crumbs->parent('admin.vpngroups.index');
    $crumbs->push($group->name, route('admin.vpngroups.show', ['id' => $id]));
});
Breadcrumbs::register('admin.vpngroups.edit', function (BreadcrumbsGenerator $crumbs, $id) {
    $group = VpnGroups::findOrFail($id);
    $crumbs->parent('admin.vpngroups.show', $id);
    $crumbs->push(trans('messages.breadcrumbs_admin_vpngroups_update'), route('admin.vpngroups.edit', $group));
});









Breadcrumbs::register('admin.vpnusers.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push(trans('messages.vpnusers'), route('admin.vpnusers.index'));
});
Breadcrumbs::register('admin.vpnusers.status', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.vpnusers.index');
    $crumbs->push(trans('messages.admin_vpnusers_connect_status'), route('admin.vpnusers.status'));
});

Breadcrumbs::register('admin.vpnusers.password', function (BreadcrumbsGenerator $crumbs, $id) {
    $crumbs->parent('admin.vpnusers.index');
    $crumbs->push(trans('messages.admin_btn_password'), route('admin.vpnusers.password', ['id' => $id]));
});
Breadcrumbs::register('admin.vpnusers.create', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.vpnusers.index');
    $crumbs->push(trans('messages.breadcrumbs_admin_vpnusers_create'), route('admin.vpnusers.create'));
});
Breadcrumbs::register('admin.vpnusers.show', function (BreadcrumbsGenerator $crumbs, $id) {
    $group = VpnUsers::findOrFail($id);
    $crumbs->parent('admin.vpnusers.index');
    $crumbs->push($group->name, route('admin.vpnusers.show', ['id' => $id]));
});
Breadcrumbs::register('admin.vpnusers.edit', function (BreadcrumbsGenerator $crumbs, $id) {
    $user = VpnUsers::findOrFail($id);
    $group = VpnGroups::findOrFail($user->group_id);
    $crumbs->parent('admin.vpnusers.show', $id);
    $crumbs->push(trans('messages.breadcrumbs_admin_vpnusers_update'), route('admin.vpnusers.edit', $group));
});



Breadcrumbs::register('admin.vpnlogs.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push(trans('messages.dashboard_admin_vpnlogs'), route('admin.vpnlogs.index'));
});

Breadcrumbs::register('admin.vpnclients.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push(trans('messages.vpnclients'), route('admin.vpnclients.index'));
});

Breadcrumbs::register('admin.vpnclients.create', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.vpnclients.index');
    $crumbs->push(trans('messages.breadcrumbs_admin_vpnusers_create'), route('admin.vpnclients.create'));
});
Breadcrumbs::register('admin.vpnclients.show', function (BreadcrumbsGenerator $crumbs, $id) {
    $client = VpnClientsTemplates::findOrFail($id);
    $crumbs->parent('admin.vpnclients.index');
    $crumbs->push($client->name, route('admin.vpnclients.show', ['id' => $id]));
});
Breadcrumbs::register('admin.vpnclients.edit', function (BreadcrumbsGenerator $crumbs, $id) {
    $client = VpnClientsTemplates::findOrFail($id);
    $crumbs->parent('admin.vpnclients.show', $id);
    $crumbs->push(trans('messages.breadcrumbs_admin_vpnclients_update'), route('admin.vpnclients.edit', $client));
});
