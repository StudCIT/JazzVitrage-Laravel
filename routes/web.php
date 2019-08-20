<?php

//Головна
Route::get('/', 'SiteController@index')->name('site');


Route::get('/application', 'ApplicationController@index');
Route::post('/application', 'ApplicationController@store');

//Конкурс
Route::get('/list-participants', 'СompetitionController@listParticipants');
Route::get('/hymn', 'СompetitionController@hymn');

//Галерея
Route::get('/video-gallery', 'GalleryController@videoGallery');
Route::get('/festival', 'GalleryController@festival');
Route::get('/jazz-workshop', 'GalleryController@jazzWorkshop');

//Положення
Route::get('/position', 'PositionController@position');

//Контакти
Route::get('/jury', 'ContactsController@jury');
Route::get('/organizing-committee', 'ContactsController@organizingCommittee');


//Админка
// Route::group(['middleware' => 'auth'], function () {

    Route::get('/admin', ['as' => 'admin.orgСommittee.newStatements', function () {
        return view('admin.orgСommittee.newStatements');
    }]);

    Route::get('/admin/removed-statements', ['as' => 'admin.orgСommittee.removedStatements', function () {
        return view('admin.orgСommittee.removedStatements');
    }]);

    Route::get('/admin/list-participants', ['as' => 'admin.orgСommittee.listParticipants', function () {
        return view('admin.orgСommittee.listParticipants');
    }]);

    Route::get('/admin/evaluation-results', ['as' => 'admin.orgСommittee.evaluationResults', function () {
        return view('admin.orgСommittee.evaluationResults');
    }]);

    Route::get('/admin/information', ['as' => 'admin.jury.information', function () {
        return view('admin.jury.information');
    }]);

    Route::get('/admin/video-gallery', ['as' => 'admin.admin.videoGallery', function () {
        return view('admin.admin.videoGallery');
    }]);

// VUE базовые роуты

    Route::get('/admin/all-statements/{any}', ['as' => 'admin.jury.allStatements', function () {
        return view('admin.jury.allStatements');
    }])->where('any', '.*');
    Route::get('/admin/all-statements', ['as' => 'admin.jury.allStatements', function () {
        return view('admin.jury.allStatements');
    }]);

// VUE запросы

    Route::get('get-members',  'ApplicationController@getMembers');

    Route::get('get-all-members',  'ApplicationController@getAllMembers');

    Route::get('get-member/{id}/',  'ApplicationController@getMember');

    Route::post('archive-members/{id}/',  'ApplicationController@archiveMembers');

    Route::post('unarchive-members/{id}/',  'ApplicationController@unarchiveMembers');

    Route::post('delete-members/{id}/',  'ApplicationController@deleteMembers');

// });
// Auth::routes();