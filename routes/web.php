<?php

Route::get('/', 'HomeController@index');

// Route::group(['middleware' => 'auth'], function () {

    Route::get('/admin', function () {
        return view('admin.home');
    });

// });
// Auth::routes();