<?php

namespace App\Http\Controllers;

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
        return view('excel.importExportUsers');
    }

    public function showLogin()
    {
        return view('login.loginTanar');
    }

    public function loginTanar(){
        $username = Input::get("username");
        $passw = Input::get("passw");
        $result = DB::select( DB::raw("SELECT Count(*) as ossz FROM tanar WHERE felhasznalo like :felhasznalo and jelszo like :jelsz"), array(
            'felhasznalo' => $username,
            'jelsz' => $passw,
        ));
        $acces = $result[0]->ossz;

        if ($acces != 0){
            return Redirect::to('importExportKerdesek');
        }
        else{
            return back()->with('success','Rossz felhasználónév vagy jelszó!');
        }
    }

    public function importTanar(Request $request)
    {
        if($request->hasFile('import_file')){
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function($reader) {})->get();

            if(!empty($data) && $data->count()){

                foreach ($data as $tanarok) {
                    if(!empty($tanarok)){
                        $insert[] = ['nev' => $tanarok['nev'],'felhasznalo' => $this->generateUsername($this->clean($tanarok['nev'])), 'jelszo' => $this->generatePassword($tanarok['nev'])];
                    }

                }

                if(!empty($insert)){
                    Tanar::insert($insert);
                    return back()->with('success',"Sikeres!");
                }

            }
        }
        return back()->with('error','Hiba!');
    }

    public function exportTanar(Request $request)
    {
        $data = Tanar::get()->toArray();
        return Excel::create('tanarok', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download();
    }

    function generateUsername(String $name) {
        $string = $this->HuToEn($name);
        $string2 = $this->splitName($string);
        $username = strtolower($string2);
        $szam = mt_rand(0,1000);
        return $username.strval($szam);
    }

    function generatePassword(String $name) {
        $string = $this->HuToEn($name);
        $string2 = $this->splitName($string);
        $pass = strtolower($string2);
        return $pass;
    }

    function HuToEn($s)
    {
        $huRo=array('/é/','/É/','/á/','/Á/','/ó/','/Ó/','/ö/','/Ö/','/ő/','/Ő/','/ú/','/Ú/','/ű/','/Ű/','/ü/','/Ü/','/í/','/Í/','/ă/','/Ă/','/â/','/Â/','/î/','/Î/','/ț/','/Ț/','/ş/','/Ș/','/-/');
        $en= array('e','E','a','A','o','O','o','O','o','O','u','U','u','U','u','U','i','I','a','A','a','A','i','I','t','T','s','S',' ');
        $r=preg_replace($huRo,$en,$s);
        return $r;
    }

    function splitName(String $name){
        $t = explode(" ", $name);
        return $t[0];
    }

    function clean($string) {
        $string = str_replace('-', '', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9 ]/', '', $string); // Removes special chars.
    }

    function doktor(String $name,String $doktor){
        if (!strcmp ($doktor , "van")){
            return $name . ', ' . 'Dr.';
        }
        else {
            return $name;
        }
    }
}
