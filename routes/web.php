<?php

use Illuminate\Support\Facades\Route;

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

// when you come on the website you go to the login screen
Route::get('/', function () {
    return redirect('/login');
});

// all routes like register/login etc.
Auth::routes();

// an redirect route when you are loged in
Route::get('/home', 'HomeController@index')->name('home');
// all url's for the notes
Route::resource('/notes','NotesController')->except(['create', 'show', 'edit']);
