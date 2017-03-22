<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use App\Kerdes;
use Input;
use Mail;

class Statisztika extends Controller
{
    public function showView(){
        $tanarok = DB::select( DB::raw("select * from tanar"));
        $szakok = DB::select( DB::raw("select * from szak"));
        return view('statisztika',['tanarok'=>$tanarok,'szakok'=>$szakok]);
    }

    public function statisztikaEgyeni()
    {
        if($_POST['action'] == 'Elonezet') {
            $this->statisztikaElonezet();
        } elseif($_POST['action'] == 'Export') {
            $this->statisztikaExport();
        }

    }

    public function statisztikaElonezet(){
        $tanar = $_POST['tanarok'];
        $szak = $_POST['szakok'];
        $valaszok = DB::select( DB::raw("select k.id,k.kerdes,avg(v.valasz) as atlag  from kerdesek k,valaszok v,tantargy t,tanar_tantargy tt 
            where v.tantargy_id = t.id and tt.tantargy_id = t.id and tt.tanar_id= :tanar and v.kerdes_id = k.id and v.szak_id = :szak group by v.kerdes_id"),
            array('tanar'=>$tanar,'szak'=>$szak));
        $nev = DB::select( DB::raw("select nev from tanar where id = :id"),array('id'=>$tanar));
        $atlag = DB::select(DB::raw("select avg(v.valasz) as atlag  from valaszok v,tantargy t,tanar_tantargy tt 
            where v.tantargy_id = t.id and tt.tantargy_id = t.id and tt.tanar_id= :tanar and v.szak_id = :szak group by v.szak_id;"),
            array('tanar'=>$tanar,'szak'=>$szak));
        $hanyan = DB::Select(DB::raw("select (count(distinct neptunkod)) as ossz from valaszok where szak_id = :szak;"),array('szak'=>$szak));

        if ($hanyan[0]->ossz == 0){
            echo 'Még nincs megjelenítendő eredmény!';
        }else if ($hanyan[0]->ossz != 0) {
            return view('statisztika',['valaszok'=>$valaszok,'tanar'=>$nev[0]->nev,'atlag'=>$atlag[0]->atlag,'hanyan'=>$hanyan[0]->ossz,'tid'=>$tanar,'szid'=>$szak]);
        }
    }

    public function statisztikaExport(){
        $tanar = $_POST['tanar'];
        $szak = $_POST['szak'];

        $hanyan = DB::Select(DB::raw("select (count(distinct neptunkod)) as ossz from valaszok where szak_id = :szak;"),array('szak'=>$szak));
        if ($hanyan[0]->ossz != 0) {
            $valaszok = DB::select(DB::raw("select k.id,k.kerdes,avg(v.valasz) as atlag  from kerdesek k,valaszok v,tantargy t,tanar_tantargy tt 
            where v.tantargy_id = t.id and tt.tantargy_id = t.id and tt.tanar_id= :tanar and v.kerdes_id = k.id and v.szak_id = :szak group by v.kerdes_id"),
                array('tanar' => $tanar, 'szak' => $szak));
            $atlag = DB::select(DB::raw("select avg(v.valasz) as atlag  from valaszok v,tantargy t,tanar_tantargy tt 
            where v.tantargy_id = t.id and tt.tantargy_id = t.id and tt.tanar_id= :tanar and v.szak_id = :szak group by v.szak_id;"),
                array('tanar' => $tanar, 'szak' => $szak));
            $nev = DB::select(DB::raw("select nev from tanar where id = :id"), array('id' => $tanar));
            foreach ($valaszok as $valasz) {
                $data[] = (array)$valasz;
            }
            array_push($data,['osszesites'=>$atlag[0]->atlag]);
            array_push($data,['hanyan'=>$hanyan[0]->ossz]);

             return Excel::create($nev[0]->nev, function($excel) use($data)
             {
                 $szak = DB::Select(DB::raw("select * from szak where id = :szak;"),array('szak'=>$_POST['szak']));
                 $excel->sheet($szak[0]->szaknev, function($sheet) use($data)
                 {
                     $sheet->cell('D1', function($cell) {
                         $cell->setValue('Összesített átlag');
                         $cell->setBackground('#0066CC');
                         $cell->setFontColor('#ffffff');

                     });
                     $sheet->cell('D2', function($cell) use($data){
                         end($data);
                         $cell->setValue(prev($data)["osszesites"]);
                         $cell->setBackground('#0066CC');
                         $cell->setFontColor('#ffffff');

                     });
                     $sheet->cell('E1', function($cell) use($data){
                         $cell->setValue('Kitöltések száma');
                         $cell->setBackground('#336600');
                         $cell->setFontColor('#ffffff');

                     });$sheet->cell('E2', function($cell) use($data){
                        $cell->setValue(end($data)["hanyan"]);
                         $cell->setBackground('#336600');
                         $cell->setFontColor('#ffffff');

                     });
                     array_pop($data);
                     array_pop($data);
                     $sheet->fromArray($data);
                 });
             })->export('xls');



        }else{
            echo 'Még nincs megjelenítendő eredmény!';
        }
    }

    public function sendMail(){
            $data = array("Sapientia EMTE");
            Mail::send($data, function($message) {
                $message->to('zattila97@yahoo.com', 'Összesítes')->subject
                ('TanárDiák-felmérő összesítés');
                $message->from('zattila97@yahoo.com','Sapientia EMTE');
            });
            echo "Email Sent with attachment. Check your inbox.";
    }
}
