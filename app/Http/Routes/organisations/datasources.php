<?php
// ----------------------------------------------------------------
// Manage routes for data information sources
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/orgs/{org}/mis-sources',                   'ProvisionTracker\MISController@index')->name('mis/index');
        Route::any('/orgs/{org}/mis-sources/{source}',          'ProvisionTracker\MISController@view')->name('mis/view');
        Route::post('/orgs/{org}/mis-sources/{source}/update',  'ProvisionTracker\MISController@update');
    });
});
