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

Route::get('/', 'PastaController@index')->name('/');

Auth::routes();

Route::get('/home', 'PastaController@index')->name('home');
Route::match(array('GET', 'POST'), '/search', array('uses'=>'PastaController@search','as'=>'search'));

Route::get('/upload', 'UploadController@index')->name('upload');

Route::resource('pasta','PastaController');

