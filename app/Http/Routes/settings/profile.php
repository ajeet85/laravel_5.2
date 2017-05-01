<?php
// ----------------------------------------------------------------
// Manage Routes for a User Profile
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/settings/profile',             'ProvisionTracker\UserController@view')->name('settings/profile');
        Route::post('/settings/profile',            'ProvisionTracker\UserController@update')->name('settings/profile');
        Route::post('/settings/profile',            'ProvisionTracker\UserController@update')->name('settings/profile');
        Route::get('/settings/change-password',     'ProvisionTracker\UserController@changePassword')->name('settings/change-password');
        Route::post('/settings/change-password',    'ProvisionTracker\UserController@editPassword')->name('settings/change-password');
        Route::get('/settings/change-email',        'ProvisionTracker\UserController@changeEmail')->name('settings/change-email');
        Route::post('/settings/change-email',       'ProvisionTracker\UserController@editEmail')->name('settings/change-email');
    });
});
