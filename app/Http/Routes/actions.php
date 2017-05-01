<?php
/*
|--------------------------------------------------------------------------
| Account actions
|--------------------------------------------------------------------------
*/
Route::get('/action/confirm/account/{action_id}', 'ProvisionTracker\AccountController@confirmAccount');


Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/settings/notifications/action/{action_id}', 'ProvisionTracker\NotificationController@action');
    });
});
/*
|--------------------------------------------------------------------------
| User actions
|--------------------------------------------------------------------------
*/
Route::get('/action/confirm/update-password/{action_id}', 'ProvisionTracker\UserController@updatePassword');
Route::get('/action/confirm/update-email/{action_id}', 'ProvisionTracker\UserController@updateEmail');
