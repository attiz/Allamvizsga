<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Input;
use App\Kerdoiv;
use App\Valasz;
use Form;

class KerdoivController extends Controller
{

    public function generateKerdoiv(){
        session_start();
        $tantargyak = array();
        $tanarok = array();
        $kerdesek = DB::select( DB::raw("SELECT * FROM kerdesek"));
        $max_id = DB::select(DB::raw("select max(kerdoiv_id) as utolso from kerdoiv"));
        $kerdoiv_id = $max_id[0]->utolso;
        if ($kerdoiv_id == NULL){
            $kerdoiv_id = 1;
        }
        else{
            $kerdoiv_id++;
        }
        if( isset($_POST['tantargyak']) && is_array($_POST['tantargyak']) ) {
                foreach ($_POST['tantargyak'] as $selected) {
                    $results = DB::select(DB::raw("SELECT id,nev as tantargy FROM tantargy where id= :tantargy_id"), array('tantargy_id' => $selected));
                    $results2 = DB::select(DB::raw("select tanar_id,nev from tanar_tantargy,tanar where tanar_tantargy.tanar_id = tanar.id and tanar_tantargy.tantargy_id = :tantargy_id and szak_id = :szak_id"),
                        array('tantargy_id' => $selected,'szak_id' => $_SESSION['szak']));
                    array_push($tantargyak, $results[0]);
                    array_push($tanarok, $results2[0]->nev);
                }

        }
        var_dump($tanarok);
        $this->insertKerdoiv();
        return view('kerdoiv',['kerdesek' => $kerdesek,'kivalasztott' => $tantargyak,'tanarok'=>$tanarok,'utolso_kerdoiv'=>$kerdoiv_id]);
    }

    public function insertKerdoiv(){
        $tantargyak = array();
        $tanarok = array();
        $kerdesek = DB::select( DB::raw("SELECT * FROM kerdesek"));
        $max_id = DB::select(DB::raw("select max(kerdoiv_id) as utolso from kerdoiv"));
        $kerdoiv_id = $max_id[0]->utolso;
        if ($kerdoiv_id == NULL){
            $kerdoiv_id = 1;
        }
        else{
            $kerdoiv_id++;
        }
        if( isset($_POST['tantargyak']) && is_array($_POST['tantargyak']) ) {
            foreach ($kerdesek as $kerdes) {
                foreach ($_POST['tantargyak'] as $selected) {
                    $results = DB::select(DB::raw("SELECT id,nev FROM tantargy where id= :tantargy_id"), array('tantargy_id' => $selected));
                    $results2 = DB::select(DB::raw("select tanar_id,nev from tanar_tantargy,tanar where tanar_tantargy.tanar_id = tanar.id and tanar_tantargy.tantargy_id = :tantargy_id and szak_id = :szak_id"),
                        array('tantargy_id' => $selected,'szak_id' => $_SESSION['szak']));
                    array_push($tantargyak, $results[0]->nev);
                    array_push($tanarok, $results2[0]->nev);
                    $kerdoiv = new kerdoiv;
                    $kerdoiv->kerdoiv_id = $kerdoiv_id;
                    $kerdoiv->kerdes_id = $kerdes->id;
                    $kerdoiv->tanar_id = $results2[0]->tanar_id;
                    $kerdoiv->tantargy_id = $results[0]->id;
                    $kerdoiv->aktiv = 1;
                    $kerdoiv->save();
                }
            }

        }
    }

    public function kerdoivKitoltes()
    {
        if(Input::get('mentes')) {

            $this->kerdoivMentes();
        } elseif(Input::get('elkuldes')) {
            $this->kerdoivElkuldes();
        }

    }

    public function kerdoivMentes(){
        session_start();
        echo 'Kérdőív kitöltve!';
        $kerdesek = DB::select( DB::raw("SELECT * FROM kerdesek"));
        $length = sizeof($_POST['tantargyak'])/sizeof($kerdesek);
        $utolso_kerdoiv =  $_POST['utolso_kerdoiv'];
        foreach ($kerdesek as  $ind => $kerdes) {
            for ($i=0; $i<$length; $i++ ) {
                $index = $ind+1;
                $index2 =  $_POST['tantargyak'][$i];
                if (isset($_POST['valaszok' . $index . $index2]) && is_array($_POST['valaszok' . $index . $index2])) {
                    foreach ($_POST['valaszok' . $index . $index2] as $selected) {
                        $valasz = new valasz;
                        $valasz -> kerdoiv_id = $utolso_kerdoiv;
                        $valasz ->kerdes_id = $index;
                        $valasz -> valasz = $selected;
                        $valasz -> tantargy_id = $index2;
                        $valasz -> neptunkod = $_SESSION['neptunkod'];
                        $valasz -> szak_id = $_SESSION['szak'];
                        $valasz -> megjegyzes = $_POST['megjegyzes'];
                        $valasz -> save();
                    }
                }

            }
        }
        return view('kitoltve');
    }

    public function kerdoivElkuldes(){
        session_start();
        echo 'Kérdőív kitöltve!';
        $kerdesek = DB::select( DB::raw("SELECT * FROM kerdesek"));
        $length = sizeof($_POST['tantargyak'])/sizeof($kerdesek);
        $utolso_kerdoiv =  $_POST['utolso_kerdoiv'];
        foreach ($kerdesek as  $ind => $kerdes) {
            for ($i=0; $i<$length; $i++ ) {
                $index = $ind+1;
                $index2 =  $_POST['tantargyak'][$i];
                if (isset($_POST['valaszok' . $index . $index2]) && is_array($_POST['valaszok' . $index . $index2])) {
                    foreach ($_POST['valaszok' . $index . $index2] as $selected) {
                        $valasz = new valasz;
                        $valasz -> kerdoiv_id = $utolso_kerdoiv;
                        $valasz ->kerdes_id = $index;
                        $valasz -> valasz = $selected;
                        $valasz -> tantargy_id = $index2;
                        $valasz -> neptunkod = $_SESSION['neptunkod'];
                        $valasz -> szak_id = $_SESSION['szak'];
                        $valasz -> megjegyzes = $_POST['megjegyzes'];
                        $valasz -> vegleges = 1;
                        $valasz -> save();
                    }
                }

            }
        }
        return view('kitoltve');
    }

    public function Kitoltve(){
        session_start();
        return view('info');
    }

    public static function isChecked(String $neptunkod,int $tantargy_id,int $kerdes_id){
        session_start();
        $valaszok = DB::select(DB::raw("select t2.tantargy_id  from kerdesek t1 left join
                        (select * from valaszok where neptunkod = :neptunkod and tantargy_id = :tantargy_id and kerdes_id = :kerdes_id) t2  on t1.id = t2.kerdes_id;"),
            array('neptunkod'=>$neptunkod, 'tantargy_id' => $tantargy_id,'kerdes_id' => $kerdes_id));
        foreach ($valaszok as $valasz) {
            if ($valasz->tantargy_id == NULL) {
                return 0;
            } elseif ($valasz->tantargy_id != NULL) {
                return 1;
            }
        }
    }

    public static function setValasz(String $neptunkod,int $tantargy_id,int $kerdes_id){
        $valaszok = DB::select(DB::raw("select t2.tantargy_id,t2.valasz  from kerdesek t1 left join
                        (select * from valaszok where neptunkod = :neptunkod and tantargy_id = :tantargy_id and kerdes_id = :kerdes_id) t2  on t1.id = t2.kerdes_id;"),
            array('neptunkod'=>$neptunkod, 'tantargy_id' => $tantargy_id,'kerdes_id' => $kerdes_id));
        foreach ($valaszok as $valasz) {
            if ($valasz->valasz == NULL) {
                return 0;
            } elseif ($valasz->valasz != NULL) {
                $ertek = $valasz->valasz;
                return $ertek;
            }
        }
    }
}

