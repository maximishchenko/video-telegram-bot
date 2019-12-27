<?php

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
