<?php
// ----------------------------------------------------------------
// Manage Routes for Organisations(schools)
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/orgs/',            'ProvisionTracker\OrganisationController@index')->name('orgs/index');
        Route::get('/orgs/new',         'ProvisionTracker\OrganisationController@add')->name('orgs/new');
        Route::post('/orgs/new',        'ProvisionTracker\OrganisationController@submit');
        Route::get('/orgs/find',        'ProvisionTracker\OrganisationController@find')->name('orgs/find');
        Route::post('/orgs/find',       'ProvisionTracker\OrganisationController@find')->name('orgs/find');
        Route::post('/orgs/switch',     'ProvisionTracker\OrganisationController@switchOrganisation');
        Route::get('/orgs/{org}',       'ProvisionTracker\OrganisationController@view')->name('orgs/view');
        Route::post('/orgs/{org}',      'ProvisionTracker\OrganisationController@update');
        Route::delete('/orgs/{org}',    'ProvisionTracker\OrganisationController@destroy');
    });
});
