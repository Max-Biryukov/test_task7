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

Route::get( '/', 'AdController@index' )->name( 'main_page' );

Auth::routes();

Route::get( '/files/{id}/{type?}', 'FileController@show' )->name( 'show_file' );

Route::resource( 'profile', 'ProfileController' )->only( ['show', 'edit', 'update'] )->middleware( 'auth' );
Route::post( 'profile/add-comment/{id}', 'ProfileController@addComment' )->middleware( 'auth' )->name( 'profile.add_comment' );
Route::post( 'profile/add-rating/{id}', 'ProfileController@addRating' )->middleware( 'auth' )->name( 'profile.add_rating' );

Route::resource( 'ads', 'AdController' )->only( ['index', 'create', 'store'] )->middleware( 'auth' );
