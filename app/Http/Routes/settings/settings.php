<?php
// ----------------------------------------------------------------
// Manage Routes for globall settings
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/settings/',                                    'ProvisionTracker\SettingsController@index')->name('settings/index');
        Route::get('/settings/permissions',                         'ProvisionTracker\SettingsController@permissions');

        Route::get('/settings/billing',                             'ProvisionTracker\BillingController@index')->name('billing/index');
        Route::get('/settings/billing/invoice/{invoice}',           'ProvisionTracker\BillingController@invoice')->name('billing/invoice');
        Route::post('/settings/billing/invoice/{invoice}/print',    'ProvisionTracker\BillingController@printInvoice')->name('billing/print');
    });
});
