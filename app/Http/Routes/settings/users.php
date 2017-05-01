<?php
// ----------------------------------------------------------------
// Manage Routes for Users
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/settings/users',                       'ProvisionTracker\SettingsController@users')->name('settings/users');
        Route::get('/settings/users/new',                   'ProvisionTracker\SettingsController@add')->name('users/new');
        Route::post('/settings/users/new',                  'ProvisionTracker\SettingsController@save')->name('users/new');
        Route::get('/settings/users/{user}/permissions',    'ProvisionTracker\SettingsController@permissions');
        Route::post('/settings/users/{user}/permissions',   'ProvisionTracker\SettingsController@updatePermissions');
    });
});
