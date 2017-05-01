<?php
// ----------------------------------------------------------------
// Manage Routes for Timeslots
Route::group(['prefix' => 'app'], function () {
    Route::group(['middleware' => ['auth', 'session.validation']], function () {
        Route::get('/manage/{org}/time-slots',                  'ProvisionTracker\TimeSlotController@index')->name('time-slots/index');
        Route::get('/manage/{org}/time-slots/new',              'ProvisionTracker\TimeSlotController@add')->name('time-slots/new');
        Route::post('/manage/{org}/time-slots/new',             'ProvisionTracker\TimeSlotController@submit');
        Route::get('/manage/{org}/time-slots/{timeslot}',       'ProvisionTracker\TimeSlotController@view')->name('time-slots/view');
        Route::post('/manage/{org}/time-slots/{timeslot}',      'ProvisionTracker\TimeSlotController@update');
        Route::delete('/manage/{org}/time-slots/{timeslot}',    'ProvisionTracker\TimeSlotController@destroy');
    });
});
