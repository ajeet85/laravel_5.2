<?php
// ----------------------------------------------------------------
// Manage Routes for resource locations
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/manage/{org}/locations',                   'ProvisionTracker\LocationResourceController@index')->name('locations/index');
        Route::get('/manage/{org}/locations/new',               'ProvisionTracker\LocationResourceController@add')->name('locations/new');
        Route::post('/manage/{org}/locations/new',              'ProvisionTracker\LocationResourceController@submit');
        Route::get('/manage/{org}/locations/{resource}',        'ProvisionTracker\LocationResourceController@view')->name('locations/view');
        Route::post('/manage/{org}/locations/{resource}',       'ProvisionTracker\LocationResourceController@update');
        Route::delete('/manage/{org}/locations/{resource}',     'ProvisionTracker\LocationResourceController@destroy');
    });
});
