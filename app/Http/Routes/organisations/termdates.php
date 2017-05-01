<?php
// ----------------------------------------------------------------
// Term Dates: School timetable for the academic year
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/orgs/{org}/terms',                     'ProvisionTracker\TermsController@index')->name('terms/index');
        Route::get('/orgs/{org}/terms/new',                 'ProvisionTracker\TermsController@add')->name('terms/new');
        Route::post('/orgs/{org}/terms/new',                'ProvisionTracker\TermsController@submit');
        Route::post('/orgs/{org}/terms/import/default',     'ProvisionTracker\TermsController@importDefault');
        Route::get('/orgs/{org}/terms/{term}',              'ProvisionTracker\TermsController@view')->name('terms/view');
        Route::post('/orgs/{org}/terms/{term}',             'ProvisionTracker\TermsController@update');
        Route::delete('/orgs/{org}/terms/{term}',           'ProvisionTracker\TermsController@destroy');
        Route::get('/orgs/{org}/term/download-template',    'ProvisionTracker\TermsController@downloadTemplate');
        Route::get('/orgs/{org}/term/import',               'ProvisionTracker\TermsController@import')->name('terms/import');
        Route::post('/orgs/{org}/term/import',              'ProvisionTracker\TermsController@importTerm');
    });
});
