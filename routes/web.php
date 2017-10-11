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

Route::resource('/reservations','reservations');
Route::resource('/museums','MuseumController');
Route::resource('/showrooms','ShowroomController');
Route::resource('/artifacts','ArtifactController');
Route::get('/findShowroom','genController@findShowroom');
Route::get('/print_marker/{id}','ArtifactController@print_marker');
