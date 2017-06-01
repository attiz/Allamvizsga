<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kerdes;
use Excel;
use DB;
use Illuminate\Support\Facades\Input;

class KerdesController extends Controller
{
    public function importKerdesek(Request $request)
    {
        if($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function ($reader) {
            })->get();

            if (!empty($data) && $data->count()) {

                foreach ($data as $kerdesek) {
                    if (!empty($kerdesek)) {
                        if (!$this->letezik($kerdesek['kerdes'])) {
                            $insert[] = ['kerdes' => $kerdesek['kerdes'], 'valasz1' => $kerdesek['valasz1'], 'valasz2' => $kerdesek['valasz2'], 'valasz3' => $kerdesek['valasz3'], 'valasz4' => $kerdesek['valasz4'], 'valasz5' => $kerdesek['valasz5']];
                        }
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
        $kerdes->valasz1 = Input::get("valasz1");
        $kerdes->valasz2 = Input::get("valasz2");
        $kerdes->valasz3 = Input::get("valasz3");
        $kerdes->valasz4 = Input::get("valasz4");
        $kerdes->valasz5 = Input::get("valasz5");
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
            $valasz1 = Input::get("valasz1");
            $valasz2 = Input::get("valasz2");
            $valasz3 = Input::get("valasz3");
            $valasz4 = Input::get("valasz4");
            $valasz5 = Input::get("valasz5");
            $kerdes->kerdes = $ker;
            $kerdes->valasz1 = $valasz1;
            $kerdes->valasz2 = $valasz2;
            $kerdes->valasz3 = $valasz3;
            $kerdes->valasz4 = $valasz4;
            $kerdes->valasz5 = $valasz5;
            if(!isset($_POST['aktiv'])){
                $kerdes->aktiv = 0;
            }
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

    function letezik(string $kerdes){
        $kerd = Kerdes::where('kerdes', '=', $kerdes)->first();
        if ($kerd == null) {
            return 0;
        }
        else{
            return 1;
        }
    }

}
