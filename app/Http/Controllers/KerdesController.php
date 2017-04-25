<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kerdes;
use Excel;
use DB;
use Illuminate\Support\Facades\Input;

class KerdesController extends Controller
{
    public function showView()
    {
        return view('excel.importExportKerdesek');
    }

    public function importKerdesek(Request $request)
    {
        if($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function ($reader) {
            })->get();

            if (!empty($data) && $data->count()) {

                foreach ($data as $kerdesek) {
                    if (!empty($kerdesek)) {
                        $insert[] = ['kerdes' => $kerdesek['kerdes'], 'valasz' => $kerdesek['valasz']];
                    }
                }

                if(!empty($insert)){
                    Kerdes::insert($insert);
                    return back()->with('success','Sikeres!');
                }

            }
        }
        return back()->with('error','Valasszon ki egy fajlt!');
    }

    public function exportKerdesek(Request $request)
    {
        $data = Kerdes::get()->toArray();
        return Excel::create('kerdesek', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download();
    }

    public function addKerdes(Request $request)
    {
        $kerdes = new kerdes;
        $kerdes->kerdes = Input::get("kerdes");
        $kerdes->valasz = Input::get("valasz");
        $kerdes->save();
        return back()->with('siker', 'Sikeres hozzáadás!');
    }

    public function addKerdesView(){
       return view('addKerdes');
    }

    public function modositKerdes(){
        session_start();
        if (isset($_POST['kerdes_id'])) {
            $adatok = DB::select(DB::raw("SELECT * FROM kerdesek WHERE id = :kerdes_id"), array(
                'kerdes_id' => $_POST['kerdes_id'],
            ));
            $_SESSION['modositKerdesId'] = $_POST['kerdes_id'];
            return view('modositKerdes', ['adatok' => $adatok]);
        }
        else{
            $adatok = DB::select(DB::raw("SELECT * FROM kerdesek WHERE id = :kerdes_id"), array(
                'kerdes_id' => $_SESSION['modositKerdesId'],
            ));
            return view('modositKerdes', ['adatok' => $adatok]);
        }
    }

    function modositKerdesAdatok()
    {
        if ($_POST['profilMentes'] == 'ment') {
            $kerdes = Kerdes::whereid($_POST['kerdes_id'])->firstOrFail();
            $ker = Input::get("kerdes");
            $valasz = Input::get("valaszok");
            $kerdes->kerdes = $ker;
            $kerdes->valasz = $valasz;
            $kerdes->save();
            return back()->with('siker', 'Sikeres mentés!');
        }

    }

    public function updateKerdesek(){
        $kerdesek = DB::select( DB::raw("SELECT * FROM kerdesek;"));
        return view('updateKerdes',['kerdesek'=>$kerdesek]);
    }

    function torolKerdes(){
        Kerdes::where('id', $_POST['kerID'])->delete();
        return back();
    }


}
