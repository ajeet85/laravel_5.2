<?php
// ----------------------------------------------------------------
// Manage Routes for Areas of Need
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/orgs/{org}/needs',                     'ProvisionTracker\AreaOfNeedController@index')->name('needs/index');
        Route::get('/orgs/{org}/needs/new',                 'ProvisionTracker\AreaOfNeedController@add')->name('needs/new');
        Route::post('/orgs/{org}/needs/new',                'ProvisionTracker\AreaOfNeedController@submit');
        Route::get('/orgs/{org}/needs/{need}',              'ProvisionTracker\AreaOfNeedController@view')->name('needs/view');
        Route::post('/orgs/{org}/needs/{need}',             'ProvisionTracker\AreaOfNeedController@update');
        Route::delete('/orgs/{org}/needs/{need}',           'ProvisionTracker\AreaOfNeedController@destroy');
        Route::post('/orgs/{org}/needs/import/default',     'ProvisionTracker\AreaOfNeedController@importDefault');
        Route::get('/orgs/{org}/need/import',               'ProvisionTracker\AreaOfNeedController@import')->name('need/import');
        Route::get('/orgs/{org}/need/download-template',    'ProvisionTracker\AreaOfNeedController@downloadTemplate')->name('need/download-template');
        Route::post('/orgs/{org}/need/import',              'ProvisionTracker\AreaOfNeedController@importNeed');
    });
});
