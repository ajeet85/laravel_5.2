<?php
// ----------------------------------------------------------------
// Manage Routes for Scheduling provisions
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/schedule/', 'ProvisionTracker\ScheduleController@view')->name('schedule/view');
    });
});
