<?php

Route::get('/', 'Admin\HomeController@index')->name('home');

Route::get('/profile', 'Auth\ProfileController@index')->name('profile');
Route::get('/profile/password', 'Auth\ProfileController@password')->name('profile.password');
Route::get('/profile/edit', 'Auth\ProfileController@edit')->name('profile.edit');
Route::put('/profile/update', 'Auth\ProfileController@update')->name('profile.update');

Auth::routes();

Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');

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

        Route::get('/vpnusers/status', 'VpnusersController@status')->name('vpnusers.status');
        Route::resource('vpnusers', 'VpnusersController');
        Route::post('/vpnclients/{client}/changeStatus', 'VpnClientsTemplatesController@changeStatus')->name('vpnclients.changeStatus');
        Route::get('/vpnclients/{client}/config', 'VpnClientsTemplatesController@config')->name('vpnclients.config');
        Route::resource('vpnclients', 'VpnClientsTemplatesController');

        Route::post('/vpnusers/{user}/changeStatus', 'VpnusersController@changeStatus')->name('vpnusers.changeStatus');
        Route::post('/vpnusers/{user}/setpassword', 'VpnusersController@setpassword')->name('vpnusers.setpassword');
        Route::get('/vpnusers/{user}/password', 'VpnusersController@password')->name('vpnusers.password');
        Route::get('/vpnlogs', 'VpnLogController@index')->name('vpnlogs.index');
        Route::get('/vpnlogs/index', 'VpnLogController@index')->name('vpnlogs.index');
        Route::get('/vpnlogs/{id}', 'VpnLogController@show')->name('vpnlogs.show');
        Route::get('/vpnlogs/getipinfo/{id}', 'VpnLogController@getipinfo')->name('vpnlogs.getipinfo');
    }
);

