<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tantargy;
use App\Szak;
use App\Orak;
use DB;
use Excel;
use Input;

class OrarendController extends Controller
{
    public function showView(){
        return view('feldolgozOrarend');
    }

    public function feltoltTantargy(Request $request){

        if($request->hasFile('import_tantargy')) {

            $path = $request->file('import_tantargy')->getRealPath();

            $data = Excel::load($path, function ($reader) {

            })->get();

            if (!empty($data) && $data->count()) {

                foreach ($data as $tantargyak) {
                    if (!empty($tantargyak)) {
                            $insert[] = ['nev' => $tantargyak['tantargy'],'rovidites' => $tantargyak['rovidites']];
                        }
                }

                if(!empty($insert)){
                    Tantargy::insert($insert);
                    return back()->with('success',"Sikeres!");
                }

            }
        }
        return back()->with('error','Hiba!');
    }

    public function feltoltOsztaly(Request $request){

        if($request->hasFile('import_osztaly')) {

            $path = $request->file('import_osztaly')->getRealPath();

            $data = Excel::load($path, function ($reader) {

            })->get();

          if (!empty($data) && $data->count()) {

                foreach ($data as $osztalyok) {
                    if (!empty($osztalyok)) {
                        $insert[] = ['szaknev' => $osztalyok['osztaly'],'rovidites' => $osztalyok['rovidites']];
                    }
                }

                if(!empty($insert)){
                    Szak::insert($insert);
                    return back()->with('success',"Sikeres!");
                }

            }
        }
       return back()->with('error','Hiba!');


    }


    public function feltoltOrak(Request $request){

        if($request->hasFile('import_orak')) {

            $path = $request->file('import_orak')->getRealPath();

            $data = Excel::load($path, function ($reader) {

            })->get();

            if (!empty($data) && $data->count()) {

                foreach ($data as $orak) {
                    if (!empty($orak)) {
                        if ($orak['osztaly'] != NULL) {
                            $osztaly = $orak['osztaly'];
                        }
                        if ($orak['tanar'] != NULL && $orak['tantargy'] != NULL) {
                            $insert[] = ['tanar_id' => $this->getTanarID($orak['tanar']),'tantargy_id' => $this->getTantargyID($orak['tantargy']),
                            'szak_id' => $this->getSzakID($osztaly)];
                        }

                    }
                }
            }
             if(!empty($insert)){
                Orak::insert($insert);
                return back()->with('success',"Sikeres!");
             }

        }
        return back()->with('error','Hiba!');
    }


    public function getTanarID(String $nev){
        $id = DB::select(DB::raw("SELECT id FROM tanar where nev= :nev"), array('nev' => $nev));
        return @$id[0]->id;
    }


    public function getTantargyID(String $tantargy){
        $id = DB::select(DB::raw("SELECT id FROM tantargy where rovidites= :nev"), array('nev' => $tantargy));
        return @$id[0]->id;
    }

    public function getSzakID(String $szak){
        $id = DB::select(DB::raw("SELECT id FROM szak where szaknev= :nev"), array('nev' => $szak));
        return @$id[0]->id;
    }

    function splitOsztaly(String $osztaly){
        $t = explode(" ", $osztaly);
        return ['nev'=>$t[0],'ev'=>$t[1]];
    }

    public function updateOrarend(){
        $szakok = DB::select(DB::raw("SELECT * FROM szak;"));
        return view('updateOrarend',['szakok'=>$szakok]);
    }

    public function showOrarend(){
        $szak_id = $_POST['szakok'];
        $orarend = DB::select(DB::raw("select t.nev, ta.nev as tantargy, szak_id from tanar_tantargy tt,tanar t,tantargy ta where tt.szak_id = :szak_id and tt.tanar_id = t.id and tt.tantargy_id = ta.id;;"),array('szak_id'=>$szak_id));
        $szakok = DB::select(DB::raw("SELECT * FROM szak;"));
        return view('updateOrarend',['szakok'=>$szakok,'orarend'=>$orarend]);
    }

}
