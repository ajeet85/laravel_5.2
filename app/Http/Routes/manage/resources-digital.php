<?php
// ----------------------------------------------------------------
// Manage Routes for Digital resources
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/manage/', 'ProvisionTracker\AppController@index');
        Route::get('/manage/{org}/digital-resources',                   'ProvisionTracker\DigitalResourceController@index')->name('digital-resources/index');
        Route::get('/manage/{org}/digital-resources/new',               'ProvisionTracker\DigitalResourceController@add')->name('digital-resources/new');
        Route::post('/manage/{org}/digital-resources/new',              'ProvisionTracker\DigitalResourceController@submit');
        Route::get('/manage/{org}/digital-resources/{resource}',        'ProvisionTracker\DigitalResourceController@view')->name('digital-resources/view');
        Route::post('/manage/{org}/digital-resources/{resource}',       'ProvisionTracker\DigitalResourceController@update');
        Route::delete('/manage/{org}/digital-resources/{resource}',     'ProvisionTracker\DigitalResourceController@destroy');
    });
});
