<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TantargyController extends Controller
{

    public function getTantargyak(){
        session_start();
        $szakok = DB::select( DB::raw("select * from szak;"));
        return view('selectTantargyak',['szakok' => $szakok]);
    }

    public function generateTantargyak(){
        session_start();
        $szak = $_POST['szakok'];
        $tantargyak = DB::select( DB::raw("select * from tanar_tantargy,tanar,tantargy where tantargy.id = tanar_tantargy.tantargy_id and 
            tanar.id = tanar_tantargy.tanar_id and szak_id  = :szak"),
            array('szak'=> $szak));
        return view ('selectTantargyak',['tantargyak' => $tantargyak]);
    }
}