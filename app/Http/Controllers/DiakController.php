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

    public function showLogin()
    {
        return view('login.loginDiak');
    }

    public function loginDiak()
    {
        session_start();
        $kod = Input::get("neptun");
        $result = DB::select(DB::raw("SELECT Count(*) as ossz FROM diak WHERE neptun = :somevariable"), array(
            'somevariable' => $kod,
        ));
        $acces = $result[0]->ossz;

        if ($acces == 1) {
            $_SESSION['neptunkod'] = $kod;
            $res = DB::select(DB::raw("SELECT Count(*) as ossz,sum(vegleges) as veg FROM valaszok WHERE neptunkod = :somevariable"), array(
                'somevariable' => $kod,
            ));
            $kitoltve = $res[0]->ossz;
            $vegleges = $res[0]->veg;
            if ($kitoltve == 0) {
                return Redirect::to('selectTantargyak');
            } elseif ($kitoltve != 0) {
                if ($vegleges == 0) {

                } else {
                    return Redirect::to('info');
                }
            }

        } else {
            return back()->with('success', 'Nincs ilyen neptun kód!');
        }
    }


    public function addDiak(Request $request)
    {
        $student = new diak;
        $student->neptun = Input::get("neptunkod");
        $result = DB::select(DB::raw("SELECT Count(*) as ossz FROM diak WHERE neptun = :somevariable"), array(
            'somevariable' => Input::get("neptunkod"),
        ));
        $acces = $result[0]->ossz;

        if ($acces == 1) {
            return back()->with('hiba', 'Ez a neptun kod már létezik!');
        }

        $student->save();

        return back()->with('siker', 'Sikeres hozzáadás!');
    }

    public function importDiak(Request $request)
    {
        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function ($reader) {
            })->get();

            if (!empty($data) && $data->count()) {

                foreach ($data as $neptunkodok) {
                    if (!empty($neptunkodok)) {
                        $insert[] = ['neptun' => $neptunkodok['hallgato_neptun_kodja']];
                    }
                }

                if (!empty($insert)) {
                    Diak::insert($insert);
                    return back()->with('success', 'Sikeres!');
                }

            }
        }

        return back()->with('error', 'Valasszon ki egy fajlt!');
    }

    public function exportDiak(Request $request)
    {
        $data = Diak::get()->toArray();
        return Excel::create('neptunkodok', function ($excel) use ($data) {
            $excel->sheet('mySheet', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download();
    }

    public function betoltKerdoiv()
    {
        $tantargyak = array();
        $tanarok = array();
        $valaszok = array();
        $kerdesek = DB::select(DB::raw("SELECT * FROM kerdesek"));
        $max_id = DB::select(DB::raw("select max(kerdoiv_id) as utolso from kerdoiv"));
        $kerdoiv_id = $max_id[0]->utolso;
        if ($kerdoiv_id == NULL) {
            $kerdoiv_id = 1;
        } else {
            $kerdoiv_id++;
        }
        $results = DB::select(DB::raw("select v.kerdes_id,v.tantargy_id,v.valasz,t.nev,v.szak_id  from valaszok v,tantargy t where t.id=v.tantargy_id and  v.neptunkod = :neptunkod"),
            array('neptunkod' => $_SESSION['neptunkod']));
        foreach ($results as $result) {
            array_push($tantargyak, $result->nev);
            array_push($tanarok, $this->getTanarNev($result->tantargy_id, $result->szak_id));
        }
        return view('kerdoiv', ['kerdesek' => $kerdesek, 'kivalasztott' => $tantargyak, 'tanarok' => $tanarok, 'utolso_kerdoiv' => $kerdoiv_id]);
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
}
/*
