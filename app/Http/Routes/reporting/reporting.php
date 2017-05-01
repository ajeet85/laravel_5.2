<?php
// ----------------------------------------------------------------
// Manage Routes for Reporting
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/reporting/', 'ProvisionTracker\AppController@index')->name('reporting/index');
    });
});
