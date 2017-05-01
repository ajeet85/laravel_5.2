<?php
// ----------------------------------------------------------------
// Manage Routes for Vulnerable Groups
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/orgs/{org}/vulnerbale-groups',                     'ProvisionTracker\VulnerableGroupController@index')->name('vulnerablegroups/index');
        Route::get('/orgs/{org}/vulnerbale-groups/new',                 'ProvisionTracker\VulnerableGroupController@add')->name('vulnerablegroups/new');
        Route::post('/orgs/{org}/vulnerbale-groups/new',                'ProvisionTracker\VulnerableGroupController@submit');
        Route::get('/orgs/{org}/vulnerbale-groups/{group}',             'ProvisionTracker\VulnerableGroupController@view')->name('vulnerablegroups/view');
        Route::post('/orgs/{org}/vulnerbale-groups/{group}',            'ProvisionTracker\VulnerableGroupController@update');
        Route::delete('/orgs/{org}/vulnerbale-groups/{group}',          'ProvisionTracker\VulnerableGroupController@destroy');
        Route::post('/orgs/{org}/vulnerbale-groups/import/default',     'ProvisionTracker\VulnerableGroupController@importDefault');
        Route::get('/orgs/{org}/vulnerbale-group/download-template',    'ProvisionTracker\VulnerableGroupController@downloadTemplate');
        Route::get('/orgs/{org}/vulnerbale-group/import',               'ProvisionTracker\VulnerableGroupController@import')->name('vulnerablegroups/import');
        Route::post('/orgs/{org}/vulnerbale-group/import',              'ProvisionTracker\VulnerableGroupController@importGroups')->name('vulnerablegroups/import');
    });
});
