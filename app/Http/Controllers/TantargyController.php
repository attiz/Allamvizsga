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
        $_SESSION['szak']=$szak;
        $tanarTantargy = array();
        $osszesTantargy = array();
        $tantargyak = DB::select( DB::raw("select * from tanar_tantargy,tanar,tantargy where tantargy.id = tanar_tantargy.tantargy_id and 
            tanar.id = tanar_tantargy.tanar_id and szak_id  = :szak"),
            array('szak'=> $szak));
        foreach ($tantargyak as $tantargy){
            array_push($osszesTantargy,$tantargy->id);
        }
        foreach ($osszesTantargy as $tantargy){
           if (is_array($this->tanarTantargy($tantargy))){
               for ($i=0;$i<sizeof($this->tanarTantargy($tantargy));$i++) {
                   array_push($tanarTantargy, $this->tanarTantargy($tantargy)[$i]);
               }
            }elseif (is_object($this->tanarTantargy($tantargy))) {
                array_push($tanarTantargy, $this->tanarTantargy($tantargy));
            }
        }
        return view ('selectTantargyak',['tantargyak' => $tanarTantargy]);
    }

    public function tanarTantargy(int $tantargy_id){
        $tantargyOsszes = DB::select(DB::raw("select distinct tanar_id,tanar.nev as tanar,tantargy_id,tantargy.nev from tanar_tantargy,tanar,tantargy where tantargy.id = tanar_tantargy.tantargy_id and
            tanar.id = tanar_tantargy.tanar_id and tantargy_id = :id;"),array('id'=>$tantargy_id));

            return $tantargyOsszes;

    }
}