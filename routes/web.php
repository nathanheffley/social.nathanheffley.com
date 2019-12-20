<?php

Route::get('/', 'ActorController@show')->name('actor');

Route::post('/inbox', 'InboxController@store')->name('inbox');

Route::get('/.well-known/webfinger', 'WebfingerController@show');

Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/home', 'HomeController@index')->name('home');
