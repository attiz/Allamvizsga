<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Tanszek;
use Illuminate\Support\Facades\Input;

class TanszekController extends Controller
{
    function hozzaadTanszekView(){
        return view('hozzaadTanszek');
    }

    function showView(){
        $tanszekek = DB::select(DB::raw("select * from tanszek;"));
        return view('tanszekView',['tanszekek'=>$tanszekek]);
    }

    public function modositTanszek(){
        session_start();
        if (isset($_POST['tanszek_id'])) {
            $adatok = DB::select(DB::raw("SELECT * FROM tanszek WHERE id = :tanszek_id"), array(
                'tanszek_id' => $_POST['tanszek_id'],
            ));
            $_SESSION['modositTanszekId'] = $_POST['tanszek_id'];
            return view('modositTanszek', ['adatok' => $adatok]);
        }
        else{
            $adatok = DB::select(DB::raw("SELECT * FROM tanszek WHERE id = :tanszek_id"), array(
                'tanszek_id' => $_SESSION['modositTanszekId'],
            ));
            return view('modositTanszek', ['adatok' => $adatok]);
        }
    }

    function modositTanszekAdatok(){
        if ($_POST['profilMentes'] == 'ment') {
            $tanszek = Tanszek::whereid($_POST['tanszek_id'])->firstOrFail();
            $tanszek->nev = Input::get("tanszek");
            $tanszek->save();
            return back()->with('siker', 'Sikeres mentés!');
        }
    }

    function torolTanszek(){
        Tanszek::where('id', $_POST['tanszID'])->delete();
        return back();
    }

    public function hozzaadTanszek(Request $request)
    {
        $tanszek = new Tanszek;
        $tanszek->nev = Input::get("tanszek");
        $tanszek->save();
        return back()->with('siker', 'Sikeres hozzáadás!');
    }
}
