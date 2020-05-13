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
Auth::routes(['verify' => false, 'reset' => false ]);

// this routes could only be accessed by the admin
Route::group(['middleware' => ['role:admin']], function() {
    // admin panel for the users route 
    Route::resource('/users','UsersController')->only(['update','index','destroy']);
    // the admin can register people
    Auth::routes(['register' => true, 'verify' => false, 'reset' => false ]);
});

// this routes could only be accessed by an admin or user
Route::group(['middleware' => ['role:admin|user']], function() {
    // an redirect route when you are loged in
    Route::get('/home', 'HomeController@index')->name('home');
    // all url's for the notes
    Route::resource('/notes','NotesController')->except(['create', 'show', 'edit']);
    // route so you can change your own user data
    Route::resource('/users','UsersController')->only(['update']);
});

// viewers of the site can't register
Auth::routes(['register' => false, 'verify' => false, 'reset' => false ]);
