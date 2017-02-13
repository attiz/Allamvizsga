<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TantargyController extends Controller
{
    public function getTantargyak(){
        $results = DB::select( DB::raw("SELECT * FROM tantargy"));
        return view('selectTantargyak',['tantargyak' => $results]);
    }
}
