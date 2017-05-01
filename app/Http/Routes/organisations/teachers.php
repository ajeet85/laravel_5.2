<?php
// ----------------------------------------------------------------
// Manage Routes for Teachers and staff members
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/orgs/{org}/teachers',              'ProvisionTracker\TeacherController@index')->name('teachers/index');
        Route::get('/orgs/{org}/teacher/new',           'ProvisionTracker\TeacherController@add')->name('teachers/new');
        Route::post('/orgs/{org}/teacher/new',          'ProvisionTracker\TeacherController@submit');
        Route::get('/orgs/{org}/teachers/{teacher}',    'ProvisionTracker\TeacherController@view')->name('teachers/view');
        Route::post('/orgs/{org}/teachers/{teacher}',   'ProvisionTracker\TeacherController@update');
        Route::delete('/orgs/{org}/teachers/{teacher}', 'ProvisionTracker\TeacherController@destroy');
    });
});
