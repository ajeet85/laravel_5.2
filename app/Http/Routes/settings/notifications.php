<?php
// ----------------------------------------------------------------
// Manage Routes for a User Profile
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/settings/notifications',        'ProvisionTracker\NotificationController@index')->name('settings/notifications');
    });
});
