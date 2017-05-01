<?php 	
// ----------------------------------------------------------------
// Manage Routes for dashboard or home page view
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/', 'ProvisionTracker\AppController@index');
    });
});
