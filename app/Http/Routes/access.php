<?php
/*
|--------------------------------------------------------------------------
| Login and Registration Routes
|--------------------------------------------------------------------------
*/
Route::get('/signup', 'ProvisionTracker\RegistrationController@index');
Route::post('/signup', 'ProvisionTracker\RegistrationController@submitRegistration');
Route::get('/logout', 'ProvisionTracker\LoginController@logout');

Route::group(['prefix' => 'login'], function () {
    Route::get('/', 'ProvisionTracker\LoginController@login');
    Route::post('/', 'ProvisionTracker\LoginController@authenticate');
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/select-account', 'ProvisionTracker\AppController@displayAccountsForSelection');
        Route::post('/select-account', 'ProvisionTracker\AppController@selectAccount');
    });
});
