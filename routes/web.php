<?php

Route::get('/', 'ActorController@show')->name('actor');

Route::get('/followers', 'FollowersController@index')->name('followers');
Route::post('/inbox', 'InboxController@store')->name('inbox');
Route::get('/outbox', 'OutboxController@index')->name('outbox');

Route::get('/note/{note}', 'NotesController@show')->name('note');

Route::get('/activity/{activity}', 'ActivitiesController@show')->name('activity');

Route::get('/.well-known/webfinger', 'WebfingerController@show');

Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/home', 'UsersController@show')->name('home');

Route::patch('/home', 'UsersController@update');

Route::post('/home/post', 'PublishPost');
