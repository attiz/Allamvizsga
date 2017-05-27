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
    public function showView()
    {
        return view('feldolgozOrarend');
    }

    public function feltoltTantargy(Request $request)
    {

        if ($request->hasFile('import_tantargy')) {

            $path = $request->file('import_tantargy')->getRealPath();

            $data = Excel::load($path, function ($reader) {

            })->get();

            if (!empty($data) && $data->count()) {

                foreach ($data as $tantargyak) {
                    if (!empty($tantargyak)) {
                        if (!$this->letezikTantargy($tantargyak['tantargy'])) {
                            $insert[] = ['nev' => $tantargyak['tantargy'], 'rovidites' => $tantargyak['rovidites']];
                        }
                    }

                }

                if (!empty($insert)) {
                    Tantargy::insert($insert);
                    return back()->with('success', "Sikeres!");
                }

            }
        }
        return back()->with('error', 'Hiba!');
    }

    public function feltoltOsztaly(Request $request)
    {

        if ($request->hasFile('import_osztaly')) {

            $path = $request->file('import_osztaly')->getRealPath();

            $data = Excel::load($path, function ($reader) {

            })->get();

            if (!empty($data) && $data->count()) {

                foreach ($data as $osztalyok) {
                    if (!empty($osztalyok)) {
                        if(!$this->letezikSzak($osztalyok['osztaly'])) {
                            $insert[] = ['szaknev' => $osztalyok['osztaly'], 'rovidites' => $osztalyok['rovidites']];
                        }
                    }
                }

                if (!empty($insert)) {
                    Szak::insert($insert);
                    return back()->with('success2', "Sikeres!");
                }

            }
        }
        return back()->with('error2', 'Hiba!');


    }


    public function feltoltOrak(Request $request)
    {

        if ($request->hasFile('import_orak')) {

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
                            $insert[] = ['tanar_id' => $this->getTanarID($orak['tanar']), 'tantargy_id' => $this->getTantargyID($orak['tantargy']),
                                'szak_id' => $this->getSzakID($osztaly), 'felev' => $this->melyikFelev()];


                        }
                    }
                }
            }
            if (!empty($insert)) {
                Orak::insert($insert);
                return back()->with('success3', "Sikeres!");
            }

        }
        return back()->with('error3', 'Hiba!');
    }


    public function getTanarID(String $nev)
    {
        $tanarNev = $this->doktorLevagas($nev);
        $id = DB::select(DB::raw("SELECT id FROM tanar where nev= :nev"), array('nev' => $tanarNev));
        return @$id[0]->id;
    }


    public function getTantargyID(String $tantargy)
    {
        $id = DB::select(DB::raw("SELECT id FROM tantargy where rovidites= :nev"), array('nev' => $tantargy));
        return @$id[0]->id;
    }

    public function getSzakID(String $szak)
    {
        $id = DB::select(DB::raw("SELECT id FROM szak where szaknev= :nev"), array('nev' => $szak));
        return @$id[0]->id;
    }

    function splitOsztaly(String $osztaly)
    {
        $t = explode(" ", $osztaly);
        return ['nev' => $t[0], 'ev' => $t[1]];
    }

    public function updateOrarend()
    {
        $szakok = DB::select(DB::raw("SELECT * FROM szak;"));
        return view('updateOrarend', ['szakok' => $szakok]);
    }

    public function showOrarend()
    {
        $szak_id = $_POST['szakok'];
        $felev = $_POST['felev'];
        $orarend = DB::select(DB::raw("select tt.id as id,t.nev, ta.nev as tantargy, szak_id from tanar_tantargy tt,tanar t,tantargy ta where tt.szak_id = :szak_id and tt.tanar_id = t.id and tt.tantargy_id = ta.id and tt.felev = :felev;")
            , array('szak_id' => $szak_id,'felev'=>$felev));
        $szakok = DB::select(DB::raw("SELECT * FROM szak;"));
        return view('updateOrarend', ['szakok' => $szakok, 'orarend' => $orarend]);
    }

    public function addOra()
    {
        return view('addOra');
    }

    function doktorLevagas(string $nev)
    {
        $arr = explode(",", $nev, 2);
        $first = $arr[0];
        return $first;
    }

    public function melyikFelev()
    { //visszaadja melyik felevben vagyunk
        $datum = date("m");
        if ((($datum >= 9) and ($datum <= 12)) || ($datum == 1)) {
            return 1;
        } elseif (($datum >= 2) and ($datum < 9)) {
            return 2;
        }
    }

    function letezikOra(int $tanar_id, int $tantargy_id, int $szak_id)
    {
        $ora = Orak::where('tanar_id', '=', $tanar_id)
            ->where('tantargy_id', '=', $tantargy_id)
            ->where('szak_id', '=', $szak_id)
            ->first();
        if ($ora == null) {
            return 0;
        } else {
            return 1;
        }
    }

    function letezikTantargy(string $tantargy)
    {
        $tant = Tantargy::where('nev', '=', $tantargy)->first();
        if ($tant == null) {
            return 0;
        } else {
            return 1;
        }
    }

    function letezikSzak(string $szak)
    {
        $sz = Szak::where('szaknev', '=', $szak)->first();
        if ($sz == null) {
            return 0;
        } else {
            return 1;
        }
    }

}
