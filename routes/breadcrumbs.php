<?php

use App\Entity\User;
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

Breadcrumbs::register('cabinet', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push(trans('messages.breadcrumbs_cabinet'), route('cabinet'));
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
