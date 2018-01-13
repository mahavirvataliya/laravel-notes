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

Auth::routes();

Route::get('/', 'NotesController@index');

Route::get('tags', 'TagController@index');
Route::post('tags', 'TagController@store');
Route::post('tagdelete', 'TagController@delete');


Route::get('home', 'NotesController@index');
Route::get('create', 'NotesController@create');
Route::post('create', 'NotesController@store');
Route::get('share/{note}', 'SharedNoteController@share');
Route::post('shares', 'SharedNoteController@storeshareNote');
Route::get('edit/{note}', 'NotesController@edit');
Route::get('view/{note}', 'NotesController@view');
Route::get('delete/{note}', 'NotesController@delete');
Route::patch('edit/{note}', 'NotesController@update');
