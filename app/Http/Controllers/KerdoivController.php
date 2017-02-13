<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class KerdoivController extends Controller
{

    public function generateKerdoiv(){
        if( isset($_POST['tantargyak']) && is_array($_POST['tantargyak']) ) {
            foreach($_POST['tantargyak'] as $selected) {
                echo 'kivalasztott:' . $selected . '<br>';
            }
        }
        $kerdesek = DB::select( DB::raw("SELECT * FROM kerdesek"));
        return view('kerdoiv',['kerdesek' => $kerdesek,'kivalasztott' => $_POST['tantargyak']]);
    }
}
