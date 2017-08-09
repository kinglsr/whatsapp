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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/home', 'HomeController@store');

Route::get('/display', 'DisplayController@index')->name('display');

Route::post('/display/getContent', 'DisplayController@getContent');

Route::get('/display/getAnalysis' , 'DisplayController@getAnalysis');



Route::get('/vue', function () {
    return view('vue');
});