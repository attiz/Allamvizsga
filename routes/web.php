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

Route::get('selectTantargyak','TantargyController@getTantargyak');

Route::get('importExportUsers', 'UserController@showView');
Route::post('importUsers', 'UserController@importUsers');
Route::get('exportUsers', 'UserController@exportUsers');

Route::get('importExportKerdesek', 'KerdesController@showView');
Route::post('addKerdes', 'KerdesController@addKerdes');
Route::post('importKerdesek', 'KerdesController@importKerdesek');
Route::get('exportKerdesek', 'KerdesController@exportKerdesek');


Route::get('importExportDiakok', 'DiakController@showView');
Route::post('addDiak', 'DiakController@addDiak');
Route::post('importDiak', 'DiakController@importDiak');
Route::get('exportDiak', 'DiakController@exportDiak');

Route::post('generateKerdoiv','KerdoivController@generateKerdoiv');
Route::post('kerdoivKitoltes','KerdoivController@kerdoivKitoltes');

Route::get('statisztikaTantargyak','Statisztika@getTantargyak');