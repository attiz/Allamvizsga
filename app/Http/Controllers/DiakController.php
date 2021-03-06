<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Diak;
use Excel;
use DB;
use View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;


class DiakController extends Controller
{
    public function showView()
    {
        return view('excel.importExportDiakok');
    }

      function bejelentkezes()
    {
        return view('bejelentkezes');
    }
    function bejelentkezes2()
    {
        return view('bejelentkezes2');
    }

    public function bejelentkezesDiak()
    {
        session_start();
        $kod = Input::get("neptun");
        $result = DB::select(DB::raw("SELECT Count(*) as ossz FROM diak WHERE neptun = :somevariable"), array(
            'somevariable' => $kod,
        )); //bejelentkezes ellenorzes
        $acces = $result[0]->ossz;

        if ($acces == 1) {
            $_SESSION['neptunkod'] = $kod;
            $res = DB::select(DB::raw("SELECT Count(*) as ossz FROM mentes,kerdoiv WHERE neptunkod = :somevariable and kerdoiv.kerdoiv_id = mentes.kerdoiv_id and kerdoiv.aktiv = 1;"), array(
                'somevariable' => $kod,
            )); //vane elmentett kerdoiv
            $res2 = DB::select(DB::raw("SELECT kitoltott FROM diak WHERE neptun = :somevariable"), array(
                'somevariable' => $kod,
            )); //vane vegelgesitett kerdoiv

            $kitoltve = $res[0]->ossz;
            $vegleges = $res2[0]->kitoltott;
            if ($vegleges == 1){ //ha mar volt veglegesitve
                return Redirect::to('info');
            }
            else{
                if ($kitoltve == 0){ //ha nincs elmentett kerdoiv
                    return Redirect::to('selectTantargyak');
                }elseif ($kitoltve != 0){ //ha van elmentett kerdoiv
                    return Redirect::to('betoltKerdoiv');
                }
            }

        } else {
            return Redirect::to('bejelentkezes')->with('hiba', 'Nincs ilyen neptun kód!');
        }
    }


    public function addDiak(Request $request) //diak hozzadadasa egyenkent
    {
        $student = new diak;
        $student->neptun = Input::get("neptunkod");
        $result = DB::select(DB::raw("SELECT Count(*) as ossz FROM diak WHERE neptun = :somevariable"), array(
            'somevariable' => Input::get("neptunkod"),
        ));
        $acces = $result[0]->ossz;

        if ($acces == 1) {
            return back()->with('hiba', 'Ez a neptun kód már létezik!');
        }

        $student->save();

        return back()->with('siker', 'Sikeres hozzáadás!');
    }

    public function importDiak(Request $request) //diak importalasa excelbol
    {
        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function ($reader) { //adatok kiolvasasa tombbe
            })->get();

            if (!empty($data) && $data->count()) {

                foreach ($data as $neptunkodok) {
                    if (!empty($neptunkodok)) {
                        if(!$this->letezik($neptunkodok['neptunkod'])) { //megnezi hogy letezik-e mar
                            $insert[] = ['neptun' => $neptunkodok['neptunkod']];
                        }
                    }
                }

                if (!empty($insert)) {
                    Diak::insert($insert); //elmenti a diakot az adatbazisba
                    return back()->with('success', 'Sikeres!');
                }

            }
        }

        return back()->with('error', 'Hiba történt!');
    }

    public function exportDiak()
    {
        $data = Diak::get()->toArray(); //adatok lekerese adabazisbol
        return Excel::create('neptunkodok', function ($excel) use ($data) { //excel file letrehozasa
            $excel->sheet('neptunkodok', function ($sheet) use ($data) {
                $sheet->fromArray($data); //a tomb adatainak beillesztese excel fajlba
            });
        })->download();
    }

    public function getTanarNev(int $tantargy, int $szak)
    {
        $res = DB::select(DB::raw("select t.nev from tanar t ,tanar_tantargy tt where tt.tanar_id = t.id and tt.tantargy_id = :tantargy and tt.szak_id = :szak; "),
            array('tantargy' => $tantargy, 'szak' => $szak));
        $tanar = $res[0]->nev;
        return $tanar;
    }

    public function getKerdesAdatok(String $neptunkod)
    {
        $results = DB::select(DB::raw("select v.kerdes_id,t.id,v.valasz,t.nev,v.szak_id  from valaszok v,tantargy t where t.id=v.tantargy_id 
                        and  v.neptunkod = :neptunkod;"),
            array('neptunkod' => $neptunkod));
        return $results;
    }

    function logoutDiak()
    {
        session_start();
        unset($_SESSION['neptunkod']);
        return Redirect::to('bejelentkezes');
    }

    function letezik(string $neptunkod){
        $diak = Diak::where('neptun', '=', $neptunkod)->first();
        if ($diak == null) {
            return 0;
        }
        else{
            return 1;
        }
    }
}

