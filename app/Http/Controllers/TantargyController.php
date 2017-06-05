<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Orak;

class TantargyController extends Controller
{

    public function getTantargyak(){
        session_start();
        $szakok = DB::select( DB::raw("select * from szak order by szaknev;"));
        return view('selectTantargyak',['szakok' => $szakok]);
    }

    public function generateTantargyak(){
        session_start();
        $szak = $_POST['szakok'];
        $_SESSION['szak']=$szak;
        $tanarTantargy = array();
        $osszesTantargy = array();
        $szaknev = DB::select(DB::raw("select szaknev from szak where id = :id;"),array('id'=>$szak));
        $nev = $szaknev[0]->szaknev;
        $tantargyak = DB::select( DB::raw("select * from tanar_tantargy,tanar,tantargy where tantargy.id = tanar_tantargy.tantargy_id and 
            tanar.id = tanar_tantargy.tanar_id and szak_id  = :szak and felev = :felev order by tantargy.nev"), //a kivalasztott szaknak a tantargyainak lekerese
            array('szak'=> $szak,'felev'=>$this->melyikFelev()));
        foreach ($tantargyak as $tantargy){
            array_push($osszesTantargy,$tantargy->id);
        }
        foreach ($osszesTantargy as $tantargy){
           if (is_array($this->tanarTantargy($tantargy,$nev))){
               for ($i=0;$i<sizeof($this->tanarTantargy($tantargy,$nev));$i++) {
                   array_push($tanarTantargy, $this->tanarTantargy($tantargy,$nev)[$i]);
               }
            }elseif (is_object($this->tanarTantargy($tantargy,$nev))) {
                array_push($tanarTantargy, $this->tanarTantargy($tantargy,$nev));
            }
        }
        return view ('selectTantargyak',['tantargyak' => $tanarTantargy]);
    }

    public function tanarTantargy(int $tantargy_id,string $szaknev){ //visszateriti a szakon belul tanult tantargyak tanarait
        $nev = explode(" ",$szaknev)[0];
        $tantargyOsszes = DB::select(DB::raw("select distinct tanar_id,tanar.nev as tanar,tantargy_id,tantargy.nev from tanar_tantargy,tanar,tantargy,szak sz 
            where tantargy.id = tanar_tantargy.tantargy_id and tanar.id = tanar_tantargy.tanar_id and tanar_tantargy.szak_id = sz.id
            and tantargy_id = :id and sz.szaknev like :nev;"),array('id'=>$tantargy_id,'nev'=>$nev.'%'));
            return $tantargyOsszes;
    }

    function modositTantargy()
    {
        session_start();
        $tanarok = DB::select(DB::raw("select * from tanar"));
        if (isset($_POST['ora_id'])) {
            $adatok = DB::select(DB::raw("select tanar.nev as tanar,tanar.id as tanar_id,tantargy.nev,tantargy.id as tantargy_id,tanar_tantargy.id as id,tanar_tantargy.szak_id as szak from tanar_tantargy,tanar,tantargy where tantargy.id = tanar_tantargy.tantargy_id and
            tanar.id = tanar_tantargy.tanar_id and tanar_tantargy.id = :id;"), array(
                'id' => $_POST['ora_id']
            ));
            $_SESSION['modositOraId'] = $_POST['ora_id'];
            return view('modositTantargy', ['adatok' => $adatok,'tanarok'=>$tanarok]);
        } else {
            $adatok = DB::select(DB::raw("select tanar.nev as tanar,tanar.id as tanar_id,tantargy.nev,tantargy.id as tantargy_id,tanar_tantargy.id as id,tanar_tantargy.szak_id as szak from tanar_tantargy,tanar,tantargy where tantargy.id = tanar_tantargy.tantargy_id and
            tanar.id = tanar_tantargy.tanar_id and tanar_tantargy.id = :id;"), array(
                'id' => $_SESSION['modositOraId']
            ));
            return view('modositTantargy', ['adatok' => $adatok,'tanarok'=>$tanarok]);
        }
    }

    function modositTantargyAdatok(){
        if ($_POST['profilMentes'] == 'ment') {
            $ora = Orak::whereid($_POST['ora_id'])->firstOrFail();
            $tanar = $_POST['tanar'];
            $tantargy = $_POST['tantargy'];
            $szak = $_POST['szak_id'];
            $ora->tanar_id = $tanar;
            $ora->tantargy_id = $tantargy;
            $ora->szak_id = $szak;
            $ora->save();
            return back()->with('siker', 'Sikeres mentés!');
        }
    }

    public function melyikFelev(){ //visszaadja melyik felevben vagyunk
        $datum = date("m");
        if ((($datum >= 9) and ($datum<=12)) || ($datum == 1)){
            return 1;
        }elseif (($datum >= 2) and ($datum <9)){
            return 2;
        }
    }
}