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
    return view('login');
});

Route::get('login', 'DiakController@showLogin');
Route::get('bejelentkezes', 'DiakController@showLogin2');
Route::get('bejelentkezes2', 'DiakController@showLogin3');
Route::post('loginDiak', 'DiakController@loginDiak');

Route::get('selectTantargyak','TantargyController@getTantargyak');
Route::post('generateTantargyak','TantargyController@generateTantargyak');

Route::post('loginTanar', 'TanarController@loginTanar');
Route::get('loginTanar', 'TanarController@showLogin');
Route::get('importExportTanar', 'TanarController@showView');
Route::post('importTanar', 'TanarController@importTanar');
Route::get('exportTanar', 'TanarController@exportTanar');
Route::get('admin', 'TanarController@update');
Route::get('updateTanar', 'TanarController@updateTanar');
Route::get('addTanar', 'TanarController@addTanarView');
Route::get('modositTanar', 'TanarController@modositTanar');
Route::get('profil', 'TanarController@profil');
Route::post('modositProfil', 'TanarController@modositProfil');
Route::get('tanar', 'TanarController@tanarView');
Route::get('logoutTanar', 'TanarController@logoutTanar');
Route::post('addTanar', 'TanarController@addTanar');
Route::post('modositTanar', 'TanarController@modositTanar');
Route::post('modositTanarAdatok', 'TanarController@modositTanarAdatok');
Route::post('modositTanarSzures', 'TanarController@modositTanarSzures');
Route::post('torolTanar', 'TanarController@torolTanar');
Route::post('frissitTanar', 'TanarController@frissitTanar');
Route::get('frissitTanar', 'TanarController@tanarFrissites');
Route::post('jelszoCsere', 'TanarController@jelszoCsere');

Route::post('addKerdes', 'KerdesController@addKerdes');
Route::post('importKerdesek', 'KerdesController@importKerdesek');
Route::get('exportKerdesek', 'KerdesController@exportKerdesek');
Route::get('updateKerdes', 'KerdesController@updateKerdesek');
Route::get('addKerdes', 'KerdesController@addKerdesView');
Route::get('modositKerdes', 'KerdesController@modositKerdes');
Route::post('modositKerdes', 'KerdesController@modositKerdes');
Route::post('modositKerdesAdatok', 'KerdesController@modositKerdesAdatok');
Route::post('addKerdes', 'KerdesController@addKerdes');
Route::post('torolKerdes', 'KerdesController@torolKerdes');

Route::get('importExportDiakok', 'DiakController@showView');
Route::post('addDiak', 'DiakController@addDiak');
Route::post('importDiak', 'DiakController@importDiak');
Route::get('exportDiak', 'DiakController@exportDiak');
Route::get('logoutDiak', 'DiakController@logoutDiak');

Route::post('generateKerdoiv','KerdoivController@generateKerdoiv');
Route::get('betoltKerdoiv','KerdoivController@betoltKerdoiv');
Route::post('kerdoivKitoltes','KerdoivController@kerdoivKitoltes');
Route::post('kerdoivElkuldes', 'KerdoivController@kerdoivElkuldes');

Route::get('statisztikaEgyeni','StatisztikaController@showView');
Route::post('statisztikaElonezet','StatisztikaController@statisztikaElonezet');
Route::post('statisztikaExport','StatisztikaController@statisztikaExport');

Route::post('feltoltTantargy', 'OrarendController@feltoltTantargy');
Route::post('feltoltOsztaly', 'OrarendController@feltoltOsztaly');
Route::post('feltoltOrak', 'OrarendController@feltoltOrak');
Route::get('feldolgozOrarend', 'OrarendController@showView');
Route::get('updateOrarend', 'OrarendController@updateOrarend');
Route::post('showOrarend', 'OrarendController@showOrarend');
Route::get('addOra', 'OrarendController@addOra');
Route::post('torolOra', 'OrarendController@torolOra');
Route::post('addOraAdatok', 'OrarendController@addOraAdatok');
Route::post('modositTantargy', 'TantargyController@modositTantargy');
Route::post('modositTantargyAdatok', 'TantargyController@modositTantargyAdatok');

Route::get('kitoltve', 'KerdoivController@kitoltve');
Route::get('mentve', 'KerdoivController@mentve');
Route::get('info', 'KerdoivController@info');

Route::get('updateTanszek', 'TanszekController@showView');
Route::get('updateTanszek', 'TanszekController@showView');
Route::get('hozzaadTanszek', 'TanszekController@hozzaadTanszekView');
Route::post('modositTanszek', 'TanszekController@modositTanszek');
Route::get('modositTanszek', 'TanszekController@modositTanszek');
Route::post('modositTanszekAdatok', 'TanszekController@modositTanszekAdatok');
Route::post('hozzaadTanszek', 'TanszekController@hozzaadTanszek');
Route::post('torolTanszek', 'TanszekController@torolTanszek');



