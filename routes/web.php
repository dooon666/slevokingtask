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

Route::get('/', function () {
	$user = ['ip' => request()->getClientIp(), 'locale' => request()->getLocale(), 'userAgent' => request()->server('HTTP_USER_AGENT')];
    return view('tasks')->with('userInfo', $user);
});

Route::get('/one', 'FirstTask')->name('one');

Route::get('/two', 'SecondTask')->name('two');

Route::get('/three', 'ThirdTask')->name('three');

Route::get('/four', 'FourthTask')->name('four');
