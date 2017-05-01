<?php
// ----------------------------------------------------------------
// Manage Routes for Pupils and students
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/orgs/{org}/pupils',            'ProvisionTracker\StudentController@index')->name('pupils/index');
        Route::get('/orgs/{org}/pupil/new',         'ProvisionTracker\StudentController@add')->name('pupil/new');
        Route::post('/orgs/{org}/pupil/new',        'ProvisionTracker\StudentController@submit')->name('pupil/new');
        Route::get('/orgs/{org}/pupils/{pupil}',    'ProvisionTracker\StudentController@view')->name('pupils/view');
        Route::post('/orgs/{org}/pupils/{pupil}',   'ProvisionTracker\StudentController@update');
        Route::delete('/orgs/{org}/pupils/{pupil}', 'ProvisionTracker\StudentController@destroy');
    });
});
