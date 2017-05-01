<?php
// ----------------------------------------------------------------
// Manage Routes for resource locations
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/manage/{org}/external-providers',                  'ProvisionTracker\ExternalProviderController@index')->name('ext-provider/index');
        Route::get('/manage/{org}/external-providers/new',              'ProvisionTracker\ExternalProviderController@add')->name('ext-provider/new');
        Route::post('/manage/{org}/external-providers/new',             'ProvisionTracker\ExternalProviderController@submit');
        Route::get('/manage/{org}/external-providers/{resource}',       'ProvisionTracker\ExternalProviderController@view')->name('ext-provider/view');
        Route::post('/manage/{org}/external-providers/{resource}',      'ProvisionTracker\ExternalProviderController@update');
        Route::delete('/manage/{org}/external-providers/{resource}',    'ProvisionTracker\ExternalProviderController@destroy');
    });
});
