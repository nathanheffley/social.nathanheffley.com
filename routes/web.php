<?php

Route::get('/', 'ActorController@show')->name('actor');

// TODO: Implement Inbox
Route::get('/inbox', function () {
    return response();
})->name('inbox');

Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/home', 'HomeController@index')->name('home');
