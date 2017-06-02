<?php

namespace App\Http\Controllers;

use App\Tanszek;
use Illuminate\Http\Request;

use App\Tanar;
use Excel;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class TanarController extends Controller
{
    public function showView()
    {
        $tanarok = DB::select(DB::raw("SELECT tanar.*,tanszek.nev as tansz FROM tanar left outer JOIN tanszek ON tanar.tanszek = tanszek.id order by tanar.nev;"));
        return view('excel.importExportUsers', ['tanarok' => $tanarok]);
    }

    public function showLogin()
    {
        return view('login.loginTanar');
    }

    public function loginTanar()
    {
        session_start();

        $username = Input::get("username");
        $passw = Input::get("passw");
        $passwHash = DB::select(DB::raw("SELECT jelszo FROM tanar WHERE felhasznalo like :felhasznalo"), array('felhasznalo' => $username));
        if ($passwHash != null){
            $res = password_verify($passw, $passwHash[0]->jelszo);
        }else{
            return Redirect::to('bejelentkezes2')->with(['error'=> 'Rossz felhasználónév vagy jelszó!','felh'=>1]);
        }

        $nev = DB::select(DB::raw("SELECT id,nev FROM tanar WHERE felhasznalo like :felhasznalo"), array(
            'felhasznalo' => $username,
        ));
        $statusz = DB::select(DB::raw("SELECT statusz FROM tanar WHERE felhasznalo like :felhasznalo"), array(
            'felhasznalo' => $username,
        ));

        if ($res && $statusz[0]->statusz == 1) {
            $_SESSION['tanar'] = $nev[0]->nev;
            $_SESSION['tanar_id'] = $nev[0]->id;

            return Redirect::to('tanar');
        } elseif ($res && $statusz[0]->statusz == 2) {
            $_SESSION['tanar'] = $nev[0]->nev;
            $_SESSION['tanar_id'] = $nev[0]->id;
            return Redirect::to('admin');
        } else {
            return Redirect::to('bejelentkezes2')->with(['error'=> 'Rossz felhasználónév vagy jelszó!','felh'=>1]);
        }
    }

    public function importTanar(Request $request)
    {
        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function ($reader) {
            })->get();

            if (!empty($data) && $data->count()) {

                foreach ($data as $tanarok) {
                    if (!empty($tanarok)) {
                        if (!$this->letezik($tanarok['nev'])) {
                            $insert[] = ['nev' => $this->doktorLevagas($tanarok['nev']), 'felhasznalo' => $this->generateUsername($this->clean($tanarok['nev'])),
                                'jelszo' => password_hash($this->generatePassword($tanarok['nev']), PASSWORD_DEFAULT)];
                        }
                    }

                }

                if (!empty($insert)) {
                    Tanar::insert($insert);
                    return back()->with('success', "Sikeres!");
                }

            }
        }
        return back()->with('error', 'Hiba!');
    }

    public function exportTanar(Request $request)
    {
        $data = Tanar::get()->toArray();
        return Excel::create('tanarok', function ($excel) use ($data) {
            $excel->sheet('mySheet', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download();
    }

    public function frissitTanar(Request $request)
    {
        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $vektor = array();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {

                foreach ($data as $tanarok) {
                    if (!empty($tanarok)) {
                        if ($this->megfeleltet($tanarok['nev']) == 1) {
                            $insert[] = ['nev' => $tanarok['nev'], 'tanszek' => $tanarok['tanszek'], 'fokozat' => $tanarok['fokozat']];
                            array_push($vektor, $tanarok['tanszek']);
                        }
                    }
                }
                $tanszekek = array_unique($vektor, SORT_REGULAR);
                if (!empty($insert)) {
                    if (!empty($tanszekek)) {
                        foreach ($tanszekek as $tansz) {
                            if(!$this->letezikTanszek($tansz)) {
                                $tanszek = new Tanszek;
                                $tanszek->nev = $tansz;
                                $tanszek->save();
                            }
                        }
                    }
                    foreach ($insert as $tanar) {
                        $tan = Tanar::where('nev', $tanar['nev'])->firstOrFail();
                        $tan->nev = $tanar['nev'];
                        $tan->tanszek = $this->getTanszekID($tanar['tanszek']);
                        $tan->fokozat = $tanar['fokozat'];
                        $tan->save();
                    }
                    return back()->with('success', "Sikeres!");
                }

            }
        }
        return back()->with('error', 'Hiba!');
    }

    public function addTanarView()
    {
        $tanszekek = DB::select(DB::raw("SELECT * FROM tanszek"));
        return view('addTanar',['tanszekek'=>$tanszekek]);
    }

    public function addTanar(Request $request)
    {
        $tanar = new tanar;
        $tanar->nev = Input::get("nev");
        $tanar->felhasznalo = $this->generateUsername(Input::get("nev"));
        $tanar->jelszo = password_hash($this->generatePassword(Input::get("nev")), PASSWORD_DEFAULT);
        $tanar->tanszek = Input::get("tanszek");
        $tanar->fokozat = Input::get("funkcio");
        $tanar->email = Input::get("email");
        $tanar->save();
        return back()->with('siker', 'Sikeres hozzáadás!');
    }

    function generateUsername(String $name)
    {
        $string = $this->HuToEn($name);
        $string2 = $this->splitName($string);
        $username = strtolower($string2);
        $szam = mt_rand(0, 10000);
        return $username . strval($szam);
    }

    function generatePassword(String $name)
    {
        $string = $this->HuToEn($name);
        $string2 = $this->splitName($string);
        $pass = strtolower($string2);
        return $pass;
    }

    function HuToEn($s)
    {
        $huRo = array('/é/', '/É/', '/á/', '/Á/', '/ó/', '/Ó/', '/ö/', '/Ö/', '/ő/', '/Ő/', '/ú/', '/Ú/', '/ű/', '/Ű/', '/ü/', '/Ü/', '/í/', '/Í/', '/ă/', '/Ă/', '/â/', '/Â/', '/î/', '/Î/', '/ț/', '/Ț/', '/ş/', '/Ș/', '/-/');
        $en = array('e', 'E', 'a', 'A', 'o', 'O', 'o', 'O', 'o', 'O', 'u', 'U', 'u', 'U', 'u', 'U', 'i', 'I', 'a', 'A', 'a', 'A', 'i', 'I', 't', 'T', 's', 'S', ' ');
        $r = preg_replace($huRo, $en, $s);
        return $r;
    }

    function splitName(String $name)
    {
        $t = explode(" ", $name);
        return $t[0];
    }

    function clean($string)
    {
        $string = str_replace('-', '', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9 ]/', '', $string); // Removes special chars.
    }

    function update()
    {
        session_start();
        return view('adminView');
    }

    function updateTanar()
    {
        return view('updateTanar');
    }

    function profil()
    {
        session_start();
        $adatok = DB::select(DB::raw("SELECT * FROM tanar WHERE id = :tanar_id"), array(
            'tanar_id' => $_SESSION['tanar_id'],
        ));
        $tanszekek = DB::select(DB::raw("SELECT * FROM tanszek"));

        return view('profil', ['adatok' => $adatok,'tanszekek'=>$tanszekek]);
    }

    function modositProfil()
    {
        session_start();
        if ($_POST['profilMentes'] == 'ment') {
            $tanar = Tanar::whereid($_SESSION['tanar_id'])->firstOrFail();
            $nev = Input::get("nev");
            $felhasznalo = Input::get("felhasznalo");
            if ($this->letezikFelhasznalo($felhasznalo)){
                return back()->with('siker', 'Már van ilyen felhasználónév!');
            }else {
                $tanszek = Input::get("tanszek");
                $fokozat = Input::get("fokozat");
                $email = Input::get("email");
                $tanar->nev = $nev;
                $tanar->felhasznalo = $felhasznalo;
                $tanar->tanszek = $tanszek;
                $tanar->fokozat = $fokozat;
                $tanar->email = $email;
                $tanar->save();
                return back()->with('siker', 'Sikeres mentés!');
            }
        }
    }

    function modositTanar()
    {
        session_start();
        if (isset($_POST['tanar_id'])) {
            $adatok = DB::select(DB::raw("SELECT * FROM tanar WHERE id = :tanar_id"), array(
                'tanar_id' => $_POST['tanar_id'],
            ));
            $tanszekek = DB::select(DB::raw("SELECT * FROM tanszek"));

            $_SESSION['modositTanarId'] = $_POST['tanar_id'];
            return view('modositTanar', ['adatok' => $adatok,'tanszekek'=>$tanszekek]);
        } else {
            $adatok = DB::select(DB::raw("SELECT * FROM tanar WHERE id = :tanar_id"), array(
                'tanar_id' => $_SESSION['modositTanarId'],
            ));
            $tanszekek = DB::select(DB::raw("SELECT * FROM tanszek"));
            return view('modositTanar', ['adatok' => $adatok,'tanszekek'=>$tanszekek]);
        }
    }

    function modositTanarAdatok()
    {
        if ($_POST['profilMentes'] == 'ment') {
            $tanar = Tanar::whereid($_POST['tanar_id'])->firstOrFail();
            $nev = Input::get("nev");
            $tanszek = Input::get("tanszek");
            $fokozat = Input::get("fokozat");
            $email = Input::get("email");
            $tanar->nev = $nev;
            $tanar->tanszek = $tanszek;
            $tanar->fokozat = $fokozat;
            $tanar->email = $email;
            $tanar->save();
            return back()->with('siker', 'Sikeres mentés!');
        }

    }

    function modositTanarSzures()
    {
        $tanarok = DB::select(DB::raw("SELECT id,nev FROM tanar order by nev;"));
        $adatok = DB::select(DB::raw("SELECT * FROM tanar where id = :id;"), array('id' => $_POST['tanarok']));
        return view('updateTanar', ['adatok' => $adatok, 'tanarok' => $tanarok, 'kivalasztott' => $_POST['tanarok']]);
    }

    function tanarFrissites()
    {
        $tanarok = DB::select(DB::raw("SELECT id,nev FROM tanar order by nev;"));
        return view('updateTanar', ['tanarok' => $tanarok]);
    }

    function torolTanar()
    {
        Tanar::where('id', $_POST['tanID'])->delete();
        return back();
    }


    function tanarView()
    {
        session_start();
        return view('tanar');
    }

    function logoutTanar()
    {
        session_start();
        session_destroy();
        session_unset();
        unset($_SESSION["tanar"]);
        $_SESSION = array();
        return view('bejelentkezes2');
    }

    function jelszoCsere()
    {
        session_start();
        $regi = Input::get("regi");
        $uj = Input::get("uj");
        $uj2 = Input::get("uj2");
        $felhasznalo = DB::select(DB::raw("SELECT felhasznalo FROM tanar WHERE id like :id"), array('id' => $_SESSION['tanar_id']));
        $passwHash = DB::select(DB::raw("SELECT jelszo FROM tanar WHERE felhasznalo like :felhasznalo"), array('felhasznalo' => $felhasznalo[0]->felhasznalo));
        $talal = password_verify($regi, $passwHash[0]->jelszo);
        if ($talal) {
            if (strcmp($uj, $uj2) == 0) {
                $ujJelszo = password_hash($uj, PASSWORD_DEFAULT);
                $user = Tanar::where('felhasznalo', '=', $felhasznalo[0]->felhasznalo)->first();
                $user->jelszo = $ujJelszo;
                $user->save();
                return Redirect::to('profil')->with('siker', 'A jelszava megváltozott!');
            } else {
                return Redirect::to('profil')->with('hiba', 'A két jelszó nem egyezik!');
            }
        } else {
            return Redirect::to('profil')->with('hiba', 'Rossz régi jelszó!');
        }
    }

    function doktorLevagas(string $nev)
    {
        $arr = explode(",", $nev, 2);
        $first = $arr[0];
        return $first;
    }

    function megfeleltet(string $nev)
    {
        $van = DB::select(DB::raw("SELECT count(*) as ossz FROM tanar WHERE nev = :nev"), array(
            'nev' => $nev,
        ));
        if ($van[0]->ossz != 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function letezik(string $nev)
    {
        $tanarNev = $this->doktorLevagas($nev);
        $tanar = Tanar::where('nev', '=', $tanarNev)->first();
        if ($tanar == null) {
            return 0;
        } else {
            return 1;
        }
    }

    public function getTanszekID(String $nev)
    {
        $id = DB::select(DB::raw("SELECT id FROM tanszek where nev= :nev"), array('nev' => $nev));
        return @$id[0]->id;
    }

    function letezikTanszek(string $nev)
    {
        $van = DB::select(DB::raw("SELECT count(*) as ossz FROM tanszek WHERE nev = :nev"), array(
            'nev' => $nev,
        ));
        if ($van[0]->ossz != 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function letezikFelhasznalo(string $felhasznalo){
        $van = DB::select(DB::raw("SELECT count(*) as ossz FROM tanar WHERE felhasznalo = :nev"), array(
            'nev' => $felhasznalo,
        ));
        if ($van[0]->ossz != 0) {
            return 1; //van
        } else {
            return 0; //nincs
        }
    }
}
