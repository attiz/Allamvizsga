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

Route::get('loginDiak', 'DiakController@showLogin');
Route::post('loginDiak', 'DiakController@loginDiak');

Route::get('loginUser', 'UserController@showLogin');
Route::post('loginUser', 'UserController@loginUser');

Route::get('selectTantargyak',function(){
    return view('selectTantargyak');
});

Route::get('importExportUsers', 'UserController@showView');
Route::post('importUsers', 'UserController@importUsers');
Route::get('exportUsers', 'UserController@exportUsers');

Route::get('importExportQuestions', 'QuestionController@showView');
Route::post('addQuestion', 'QuestionController@addQuestion');
Route::post('importQuestions', 'QuestionController@importQuestions');
Route::get('exportQuestions', 'QuestionController@exportQuestions');


Route::get('importExportDiakok', 'DiakController@showView');
Route::post('addDiak', 'DiakController@addDiak');
Route::post('importDiak', 'DiakController@importDiak');
Route::get('exportDiak', 'DiakController@exportDiak');

