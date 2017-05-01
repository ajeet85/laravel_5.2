<?php
// ----------------------------------------------------------------
// Manage Routes for Digital resources
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/manage/{org}/physical-resources',                  'ProvisionTracker\PhysicalResourceController@index')->name('physical-resources/index');
        Route::get('/manage/{org}/physical-resources/new',              'ProvisionTracker\PhysicalResourceController@add')->name('physical-resources/new');
        Route::post('/manage/{org}/physical-resources/new',             'ProvisionTracker\PhysicalResourceController@submit');
        Route::get('/manage/{org}/physical-resources/{resource}',       'ProvisionTracker\PhysicalResourceController@view')->name('physical-resources/view');
        Route::post('/manage/{org}/physical-resources/{resource}',      'ProvisionTracker\PhysicalResourceController@update');
        Route::delete('/manage/{org}/physical-resources/{resource}',    'ProvisionTracker\PhysicalResourceController@destroy');
    });
});
