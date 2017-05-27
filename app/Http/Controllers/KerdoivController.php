<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Input;
use App\Kerdoiv;
use App\Valasz;
use App\MentettValaszok;
use App\Megjegyzes;
use Form;
use Illuminate\Support\Facades\Redirect;


class KerdoivController extends Controller
{

    public function generateKerdoiv()
    {
        session_start();
        $tantargyak = array();
        $tanarok = array();
        $kerdesek = DB::select(DB::raw("SELECT * FROM kerdesek where aktiv = 1"));
        $max_id = DB::select(DB::raw("select max(kerdoiv_id) as utolso from kerdoiv"));
        $kerdoiv_id = $max_id[0]->utolso;
        if ($kerdoiv_id == NULL) {
            $kerdoiv_id = 1;
        } else {
            $kerdoiv_id++;
        }
        if (isset($_POST['tantargyak']) && is_array($_POST['tantargyak'])) {

            foreach ($_POST['tantargyak'] as $selected) {
                list($tantargy_id, $tanar_id) = explode('|', $selected);
                $results = DB::select(DB::raw("SELECT id,nev as tantargy FROM tantargy where id= :tantargy_id"), array('tantargy_id' => (int)$tantargy_id));
                $results2 = DB::select(DB::raw("select tanar_id,nev from tanar_tantargy,tanar where tanar_tantargy.tanar_id = tanar.id and tanar_tantargy.tantargy_id = :tantargy_id and tanar_id = :tanar_id"),
                    array('tantargy_id' => (int)$tantargy_id, 'tanar_id' => (int)$tanar_id));
                array_push($tantargyak, $results[0]);
                array_push($tanarok, $results2[0]);
            }
            $kerdoiv = new kerdoiv;
            $kerdoiv->kerdoiv_id = $kerdoiv_id;
            $kerdoiv->aktiv = 1;
            $kerdoiv->save();
        }
        return view('kerdoiv', ['kerdesek' => $kerdesek, 'tantargyak' => $tantargyak, 'tanarok' => $tanarok, 'utolso_kerdoiv' => $kerdoiv_id]);
    }

    public function betoltKerdoiv(){
        session_start();
        $kerdesek = DB::select(DB::raw("SELECT * FROM kerdesek where aktiv=1"));
        $tanarok = array();
        $kerdoiv = DB::select(DB::raw("select kerdoiv_id from mentes where neptunkod =:neptunkod"), array('neptunkod'=>$_SESSION['neptunkod']));
        $kerdoiv_id = $kerdoiv[0]->kerdoiv_id;
        $tantargyak = DB::select(DB::raw("select distinct v.tantargy_id as id,t.nev,v.szak_id from mentes v,tantargy t where t.id=v.tantargy_id and  v.neptunkod = :neptun"),
            array('neptun'=>$_SESSION['neptunkod']));

        foreach ($tantargyak as $t) {
            $result = DB::select(DB::raw("select tanar_id,nev from tanar_tantargy,tanar where tanar_tantargy.tanar_id = tanar.id and tanar_tantargy.tantargy_id = :tantargy_id and szak_id = :szak;"),
                array('tantargy_id' => (int)$t->id, 'szak'=>$t->szak_id));
            array_push($tanarok,$result[0]);
        }

        $valaszok  =  DB::select(DB::raw("select * from mentes where neptunkod = :neptunkod;"),
            array('neptunkod' => $_SESSION['neptunkod']));

        return view('betoltKerdoiv', ['kerdesek' => $kerdesek,'kerdoiv_id'=>$kerdoiv_id,'tantargyak'=>$tantargyak,'tanarok'=>$tanarok,'valaszok' => $valaszok]);
    }

    public function kerdoivElkuldes()
    {
        session_start();
        $valaszok = Input::get("valaszok");
        if (is_array($valaszok) || is_object($valaszok)) {
            if (end($valaszok)["vegleges"] == 1) {
                for ($i = 0; $i < sizeof($valaszok) - 1; $i++) {

                    if ($valaszok[$i]['pont'] != 0) {
                        $valasz = new valasz;
                        $valasz->kerdes_id = $valaszok[$i]['kerdes_id'];
                        $valasz->kerdoiv_id = $valaszok[$i]['utolso_kerdoiv'];
                        $valasz->valasz = $valaszok[$i]['pont'];
                        $valasz->tantargy_id = $valaszok[$i]['tantargy_id'];
                        $valasz->tanar_id = $valaszok[$i]['tanar_id'];
                        $valasz->szak_id = $valaszok[$i]['szak_id'];
                        $valasz->tanev = $this->melyikTanev();
                        $valasz->felev = $this->melyikFelev();
                       $valasz->save();
                    }
                    if (end($valaszok)["megjegyzes"] != NULL) {
                        $megjegyzes = new megjegyzes;
                        $megjegyzes->neptunkod = $_SESSION['neptunkod'];
                        $megjegyzes->megjegyzes = end($valaszok)["megjegyzes"];
                        $megjegyzes->save();
                    }
                }
            } else if (end($valaszok)["vegleges"] == 0){
                for ($i = 0; $i < sizeof($valaszok) - 1; $i++) {
                    if ($valaszok[$i]['pont'] != 0) {
                        $mentes = new MentettValaszok;
                        $mentes->kerdes_id = $valaszok[$i]['kerdes_id'];
                        $mentes->kerdoiv_id = $valaszok[$i]['utolso_kerdoiv'];
                        $mentes->valasz = $valaszok[$i]['pont'];
                        $mentes->tantargy_id = $valaszok[$i]['tantargy_id'];
                        $mentes->tanar_id = $valaszok[$i]['tanar_id'];
                        $mentes->neptunkod = $valaszok[$i]['neptunkod'];
                        $mentes->szak_id = $valaszok[$i]['szak_id'];
                        $mentes->save();
                    }
                    if (end($valaszok)["megjegyzes"] != NULL) {
                        $megjegyzes = new megjegyzes;
                        $megjegyzes->neptunkod = $_SESSION['neptunkod'];
                        $megjegyzes->megjegyzes = end($valaszok)["megjegyzes"];
                        $megjegyzes->save();
                    }
                }
            }
        }
        return response()->json(array('msg' => $valaszok), 200);
    }

    public function Kitoltve()
    {
        session_start();
        return view('kitoltve');
    }

    public function mentve()
    {
        return view('mentve');
    }

    public function info()
    {
        session_start();
        return view('info');
    }

    public static function isChecked(String $neptunkod, int $tantargy_id, int $kerdes_id)
    {
        session_start();
        $valaszok = DB::select(DB::raw("select t2.tantargy_id  from kerdesek t1 left join
                        (select * from valaszok where neptunkod = :neptunkod and tantargy_id = :tantargy_id and kerdes_id = :kerdes_id) t2  on t1.id = t2.kerdes_id;"),
            array('neptunkod' => $neptunkod, 'tantargy_id' => $tantargy_id, 'kerdes_id' => $kerdes_id));
        foreach ($valaszok as $valasz) {
            if ($valasz->tantargy_id == NULL) {
                return 0;
            } elseif ($valasz->tantargy_id != NULL) {
                return 1;
            }
        }
    }

    public static function setValasz(String $neptunkod, int $tantargy_id, int $kerdes_id)
    {
        $valaszok = DB::select(DB::raw("select t2.tantargy_id,t2.valasz  from kerdesek t1 left join
                        (select * from valaszok where neptunkod = :neptunkod and tantargy_id = :tantargy_id and kerdes_id = :kerdes_id) t2  on t1.id = t2.kerdes_id;"),
            array('neptunkod' => $neptunkod, 'tantargy_id' => $tantargy_id, 'kerdes_id' => $kerdes_id));
        foreach ($valaszok as $valasz) {
            if ($valasz->valasz == NULL) {
                return 0;
            } elseif ($valasz->valasz != NULL) {
                $ertek = $valasz->valasz;
                return $ertek;
            }
        }
    }

    public function getTanarNev(int $tantargy, int $szak)
    {
        $res = DB::select(DB::raw("select t.nev from tanar t ,tanar_tantargy tt where tt.tanar_id = t.id and tt.tantargy_id = :tantargy and tt.szak_id = :szak; "),
            array('tantargy' => $tantargy, 'szak' => $szak));
        $tanar = $res[0]->nev;
        return $tanar;
    }

    public function melyikFelev(){ //visszaadja melyik felevben vagyunk
        $datum = date("m");
        if ((($datum >= 9) and ($datum<=12)) || ($datum == 1)){
            return 1;
        }elseif (($datum >= 2) and ($datum <9)){
            return 2;
        }
    }

    public function melyikTanev(){ //visszaadja melyik tanevben vagyunk
        $ev = date('Y');
        $honap = date("m");
        if ($honap >= 9 ){
            return $ev.'/'.$ev+1;
        }
        elseif($honap <9){
            return $ev-1 .'/'.$ev;
        }
    }
}

