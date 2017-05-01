<?php
// ----------------------------------------------------------------
// Manage Routes for Provisions
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/manage/{org}/wonde/students', 'ProvisionTracker\WondeController@getStudents');
        Route::get('/manage/{org}/wonde/employees', 'ProvisionTracker\WondeController@getEmployees');
        Route::get('/manage/{org}/wonde/groups', 'ProvisionTracker\WondeController@getGroups');
        Route::get('/manage/{org}/wonde/classes', 'ProvisionTracker\WondeController@getClasses');
        Route::get('/manage/{org}/wonde/import', 'ProvisionTracker\WondeController@importSchoolMisData');
    });
});
