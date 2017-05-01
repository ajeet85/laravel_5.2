<?php
// ----------------------------------------------------------------
// Manage Routes for Provisions
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/manage/{org}/provisions',                  'ProvisionTracker\ProvisionController@index')->name('provisions/index');
        Route::get('/manage/{org}/provisions/new',              'ProvisionTracker\ProvisionController@add')->name('provisions/new');
        Route::post('/manage/{org}/provisions/new',             'ProvisionTracker\ProvisionController@submit');
        Route::get('/manage/{org}/provisions/{provision}',      'ProvisionTracker\ProvisionController@view')->name('provisions/view');
        Route::post('/manage/{org}/provisions/{provision}',     'ProvisionTracker\ProvisionController@update');
        Route::delete('/manage/{org}/provisions/{provision}',   'ProvisionTracker\ProvisionController@destroy');
        
    });
});
