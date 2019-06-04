<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home page
Route::get('/', function () {
    return view('pages.home');
})->name('page.home');

// Dashboard page
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('page.dashboard');

// Email page
Route::get('/emails', function () {
    return view('pages.emails');
})->name('page.dashboard.emails');
