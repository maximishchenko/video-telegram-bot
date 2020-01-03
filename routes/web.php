<?php

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');

Route::get('/cabinet', 'Cabinet\HomeController@index')->name('cabinet');

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::post('/users/{user}/changeStatus', 'UsersController@changeStatus')->name('users.changeStatus');
        Route::post('/users/{user}/setpassword', 'UsersController@setpassword')->name('users.setpassword');
        Route::get('/users/{user}/password', 'UsersController@password')->name('users.password');
        Route::resource('users', 'UsersController');
        Route::post('/vpngroups/{user}/changeStatus', 'VpngroupsController@changeStatus')->name('vpngroups.changeStatus');
        Route::resource('vpngroups', 'VpngroupsController');
        Route::resource('vpnusers', 'VpnusersController');
        Route::post('/vpnusers/{user}/changeStatus', 'VpnusersController@changeStatus')->name('vpnusers.changeStatus');
        Route::post('/vpnusers/{user}/setpassword', 'VpnusersController@setpassword')->name('vpnusers.setpassword');
        Route::get('/vpnusers/{user}/password', 'VpnusersController@password')->name('vpnusers.password');

    }
);

