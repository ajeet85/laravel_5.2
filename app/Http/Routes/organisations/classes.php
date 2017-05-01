<?php
// ----------------------------------------------------------------
// Manage Routes for Pupils and students
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/orgs/{org}/classes',           'ProvisionTracker\ClassController@index')->name('classes/index');
        Route::get('/orgs/{org}/classes/new',       'ProvisionTracker\ClassController@add')->name('classes/new');
        Route::post('/orgs/{org}/classes/new',      'ProvisionTracker\ClassController@submit');
        Route::get('/orgs/{org}/classes/{class}',   'ProvisionTracker\ClassController@view')->name('classes/view');
        Route::post('/orgs/{org}/classes/{class}',  'ProvisionTracker\ClassController@update');
        Route::delete('/orgs/{org}/classes/{class}', 'ProvisionTracker\ClassController@destroy');
    });
});
