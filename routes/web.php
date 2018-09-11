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

Route::get( '/home', 'HomeController@index' )->name( 'home' );
Route::get( '/files/{id}/{type?}', 'FileController@show' )->name( 'show_file' );

Route::resource( 'profile', 'ProfileController' )->only( ['index', 'show', 'edit', 'update'] )->middleware( 'auth' );
/*
Route::get('profile', [
  'middleware' => 'auth',
  'uses' => 'ProfileController@show'
]);*/