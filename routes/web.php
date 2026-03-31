<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/home1', function () {
    return view('home');
});
Route::get('/welcome', function () {
    return view('home');
});