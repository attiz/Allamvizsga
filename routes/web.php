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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('loginDiak', 'DiakController@showLogin');
Route::post('loginDiak', 'DiakController@loginDiak');

Route::get('loginTanar', 'TanarController@showLogin');
Route::post('loginTanar', 'TanarController@loginTanar');

Route::get('selectTantargyak','TantargyController@getTantargyak');
Route::post('generateTantargyak','TantargyController@generateTantargyak');

Route::get('importExportTanar', 'TanarController@showView');
Route::post('importTanar', 'TanarController@importTanar');
Route::get('exportTanar', 'TanarController@exportTanar');
Route::get('admin', 'TanarController@update');
Route::get('updateTanar', 'TanarController@updateTanar');
Route::get('addTanar', 'TanarController@addTanar');
Route::get('profil', 'TanarController@profil');
Route::get('tanar', 'TanarController@tanarView');

Route::get('importExportKerdesek', 'KerdesController@showView');
Route::post('addKerdes', 'KerdesController@addKerdes');
Route::post('importKerdesek', 'KerdesController@importKerdesek');
Route::get('exportKerdesek', 'KerdesController@exportKerdesek');
Route::get('updateKerdes', 'KerdesController@updateKerdesek');

Route::get('importExportDiakok', 'DiakController@showView');
Route::post('addDiak', 'DiakController@addDiak');
Route::post('importDiak', 'DiakController@importDiak');
Route::get('exportDiak', 'DiakController@exportDiak');

Route::post('generateKerdoiv','KerdoivController@generateKerdoiv');
Route::post('kerdoivKitoltes','KerdoivController@kerdoivKitoltes');

Route::get('statisztikaEgyeni','Statisztika@showView');
Route::post('statisztikaElonezet','Statisztika@statisztikaElonezet');
Route::post('statisztikaExport','Statisztika@statisztikaExport');

Route::post('feltoltTantargy', 'OrarendController@feltoltTantargy');
Route::post('feltoltOsztaly', 'OrarendController@feltoltOsztaly');
Route::post('feltoltOrak', 'OrarendController@feltoltOrak');
Route::get('feldolgozOrarend', 'OrarendController@showView');
Route::get('updateOrarend', 'OrarendController@updateOrarend');
Route::post('showOrarend', 'OrarendController@showOrarend');

Route::get('kitoltve', 'KerdoivController@kitoltve');