<?php
// ----------------------------------------------------------------
// Manage Routes for Assessment types
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/orgs/{org}/assessment-types',                  'ProvisionTracker\AssessmentTypeController@index')->name('assessment-types/index');
        Route::post('/orgs/{org}/assessment-types/copy',            'ProvisionTracker\AssessmentTypeController@copy');
        Route::post('/orgs/{org}/assessment-types/new',             'ProvisionTracker\AssessmentTypeController@add');
        Route::get('/orgs/{org}/assessment-types/{assessment}',     'ProvisionTracker\AssessmentTypeController@view')->name('assessment-types/view');
        Route::post('/orgs/{org}/assessment-types/{assessment}',    'ProvisionTracker\AssessmentTypeController@update');
        Route::delete('/orgs/{org}/assessment-types/{assessment}',  'ProvisionTracker\AssessmentTypeController@destroy');
        Route::post('/orgs/{org}/assessment-types/import/default',  'ProvisionTracker\AssessmentTypeController@importDefault');
        Route::get('/orgs/{org}/assessment-type/download-template', 'ProvisionTracker\AssessmentTypeController@downloadTemplate');
        Route::get('/orgs/{org}/assessment-type/import',            'ProvisionTracker\AssessmentTypeController@import')->name('assessment-types/import');
        Route::post('/orgs/{org}/assessment-type/import',           'ProvisionTracker\AssessmentTypeController@importAssesments')->name('assessment-types/import');
    });
});
