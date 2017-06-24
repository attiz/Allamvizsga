<?php

namespace App\Http\Controllers;

use App\Tanszek;
use App\Fokozat;
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
        $tanarok = DB::select(DB::raw("SELECT tanar.*,tanszek.nev as tansz,fokozat.fokozat as fok FROM tanar left outer JOIN tanszek ON tanar.tanszek = tanszek.id
                                        left outer JOIN fokozat on  tanar.fokozat = fokozat.id order by tanar.nev;"));
        return view('excel.importExportUsers', ['tanarok' => $tanarok]);
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
            $vektor2 = array();
            $data = Excel::load($path, function ($reader) {
            })->get();
            if (!empty($data) && $data->count()) {

                foreach ($data as $tanarok) {
                    if (!empty($tanarok)) {
                        if ($this->megfeleltet($tanarok['nev']) == 1) {
                            $insert[] = ['nev' => $tanarok['nev'], 'tanszek' => $tanarok['tanszek'], 'fokozat' => $tanarok['fokozat']];
                            array_push($vektor, $tanarok['tanszek']);
                            array_push($vektor2, $tanarok['fokozat']);
                        }
                    }
                }
                $tanszekek = array_unique($vektor, SORT_REGULAR);
                $fokozatok = array_unique($vektor2, SORT_REGULAR);
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
                    if (!empty($fokozatok)) {
                        foreach ($fokozatok as $fokoz) {
                            if(!$this->letezikFokozat($fokoz)) {
                                $fokozat = new Fokozat;
                                $fokozat->fokozat = $fokoz;
                                $fokozat->save();
                            }
                        }
                    }
                    foreach ($insert as $tanar) {
                        $tan = Tanar::where('nev', $tanar['nev'])->firstOrFail();
                        $tan->nev = $tanar['nev'];
                        $tan->tanszek = $this->getTanszekID($tanar['tanszek']);
                        $tan->fokozat = $this->getFokozatID($tanar['fokozat']);
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
        $fokozatok = DB::select(DB::raw("SELECT * FROM fokozat"));
        $funkcio = array('egyetemi tanár'=>1,'tanszékvezető'=>2,'dékán'=>3);
        return view('hozzaadTanar',['tanszekek'=>$tanszekek,'funkcio'=>$funkcio,'fokozatok'=>$fokozatok]);
    }

    public function addTanar(Request $request)
    {
        $tanar = new tanar;
        $tanar->nev = Input::get("nev");
        $tanar->felhasznalo = $this->generateUsername(Input::get("nev"));
        $tanar->jelszo = password_hash($this->generatePassword(Input::get("nev")), PASSWORD_DEFAULT);
        $tanar->tanszek = Input::get("tanszek");
        $tanar->fokozat = Input::get("fokozat");
        $tanar->email = Input::get("email");
        $tanar->funkcio = Input::get("funkcio");
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
        $fokozatok = DB::select(DB::raw("SELECT * FROM fokozat"));

        return view('profil', ['adatok' => $adatok,'tanszekek'=>$tanszekek,'fokozatok'=>$fokozatok]);
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
        $funkcio = array('egyetemi tanár'=>1,'tanszékvezető'=>2,'dékán'=>3);
        if (isset($_POST['tanar_id'])) {
            $adatok = DB::select(DB::raw("SELECT * FROM tanar WHERE id = :tanar_id"), array(
                'tanar_id' => $_POST['tanar_id'],
            ));
            $tanszekek = DB::select(DB::raw("SELECT * FROM tanszek"));
            $fokozatok = DB::select(DB::raw("SELECT * FROM fokozat"));

            $_SESSION['modositTanarId'] = $_POST['tanar_id'];
            return view('modositTanar', ['adatok' => $adatok,'tanszekek'=>$tanszekek,'funkcio'=>$funkcio,'fokozatok'=>$fokozatok]);
        } else {
            $adatok = DB::select(DB::raw("SELECT * FROM tanar WHERE id = :tanar_id"), array(
                'tanar_id' => $_SESSION['modositTanarId'],
            ));
            $tanszekek = DB::select(DB::raw("SELECT * FROM tanszek"));
            $fokozatok = DB::select(DB::raw("SELECT * FROM fokozat"));
            return view('modositTanar', ['adatok' => $adatok,'tanszekek'=>$tanszekek,'funkcio'=>$funkcio,'fokozatok'=>$fokozatok]);
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
            $funkcio = Input::get("funkcio");
            $tanar->nev = $nev;
            $tanar->tanszek = $tanszek;
            $tanar->fokozat = $fokozat;
            $tanar->email = $email;
            $tanar->funkcio = $funkcio;
            $tanar->save();
            return back()->with('siker', 'Sikeres mentés!');
        }

    }

    function modositTanarAdatokSzures()
    {
        if ($_POST['profilMentes'] == 'ment') {
            $tanar = Tanar::whereid($_POST['tanar_id'])->firstOrFail();
            $nev = Input::get("nev");
            $tanszek = Input::get("tanszek");
            $fokozat = Input::get("fokozat");
            $email = Input::get("email");
            $funkcio = Input::get("funkcio");
            $tanar->nev = $nev;
            $tanar->tanszek = $tanszek;
            $tanar->fokozat = $fokozat;
            $tanar->email = $email;
            $tanar->funkcio = $funkcio;
            $tanar->save();
            return Redirect::to('importExportTanar')->with('siker', 'Sikeres mentés!');
        }

    }

    function modositTanarSzures()
    {
        $tanarok = DB::select(DB::raw("SELECT id,nev FROM tanar order by nev;"));
        $tanszekek = DB::select(DB::raw("SELECT * FROM tanszek"));
        $fokozatok = DB::select(DB::raw("SELECT * FROM fokozat"));
        $funkcio = array('egyetemi tanár'=>1,'tanszékvezető'=>2,'dékán'=>3);
        $adatok = DB::select(DB::raw("SELECT * FROM tanar where id = :id;"), array('id' => $_POST['tanarok']));
        return view('updateTanar', ['adatok' => $adatok, 'tanarok' => $tanarok, 'kivalasztott' => $_POST['tanarok'],'tanszekek'=>$tanszekek,'fokozatok'=>$fokozatok,'funkcio'=>$funkcio]);
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
    public function getFokozatID(String $fokozat)
    {
        $id = DB::select(DB::raw("SELECT id FROM fokozat where fokozat= :fokozat"), array('fokozat' => $fokozat));
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

    function letezikFokozat(string $fokozat)
    {
        $van = DB::select(DB::raw("SELECT count(*) as ossz FROM fokozat WHERE fokozat = :fokozat"), array(
            'fokozat' => $fokozat,
        ));
        if ($van[0]->ossz != 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function letezikFelhasznalo(string $felhasznalo){
        $van = DB::select(DB::raw("SELECT count(*) as ossz FROM tanar WHERE felhasznalo = :nev and id != :id"), array(
            'nev' => $felhasznalo,'id'=>$_SESSION['tanar_id'],
        ));
        if ($van[0]->ossz != 0) {
            return 1; //van
        } else {
            return 0; //nincs
        }
    }
}
