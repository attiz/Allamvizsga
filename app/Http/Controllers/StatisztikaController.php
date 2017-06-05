<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use App\Kerdes;
use Illuminate\Support\Facades\Redirect;
use Input;
use Mail;

class StatisztikaController extends Controller
{
    public function showView()
    {
        session_start();
        $funkcio = DB::select(DB::raw("select funkcio,statusz from tanar where id =:id order by nev"), array('id' => $_SESSION['tanar_id']));
        if ($funkcio[0]->statusz == 2) {
            $tanarok = DB::select(DB::raw("select * from tanar order by nev"));
            return view('statisztika', ['tanarok' => $tanarok]);
        } else {
            if ($funkcio[0]->funkcio == 1) {
                $tanarok = DB::select(DB::raw("select * from tanar where id =:id order by nev"), array('id' => $_SESSION['tanar_id']));
                $szakok = DB::select(DB::raw("select distinct szak.id, szak.szaknev from tanar_tantargy,szak where tanar_tantargy.szak_id = szak.id and 
                          tanar_tantargy.tanar_id =:id order by szaknev"), array('id' => $_SESSION['tanar_id']));
                return view('statisztika', ['tanarok' => $tanarok, 'szakok' => $szakok]);

            } elseif ($funkcio[0]->funkcio == 2) {
                $tanszek = DB::select(DB::raw("select tanszek from tanar where id =:id order by nev"), array('id' => $_SESSION['tanar_id']));
                $tanarok = DB::select(DB::raw("select * from tanar where tanszek =:tanszek order by nev"), array('tanszek' => $tanszek[0]->tanszek));
                return view('statisztika', ['tanarok' => $tanarok]);
            } elseif ($funkcio[0]->funkcio == 3) {
                $tanarok = DB::select(DB::raw("select * from tanar order by nev"));
                return view('statisztika', ['tanarok' => $tanarok]);
            }
        }
    }

    function getSzakok()
    {
        $tanar_id = Input::get("tanar_id");
        $sz = array();
        $szakok = DB::select(DB::raw("select szak.szaknev,szak.id from tanar_tantargy,szak where tanar_tantargy.szak_id = szak.id
                                and tanar_tantargy.tanar_id = :tanar_id order by szak.szaknev"), array('tanar_id' => $tanar_id));
        foreach ($szakok as $szak) {
            array_push($sz, ['id' => $szak->id, 'nev' => $szak->szaknev]);
        }
        $tanar_szak = array_unique($sz, SORT_REGULAR);

        return response()->json(array('szakok' => $tanar_szak), 200);
    }

    function getTantargyak()
    {
        $idk = Input::get("element");
        $szak_id = $idk['szak_id'];
        $tanar_id = $idk['tanar_id'];
        $tt = array();
        $tantargyak = DB::select(DB::raw("select tantargy.nev,tantargy.id from tanar_tantargy,tantargy where tanar_tantargy.tantargy_id = tantargy.id
                                and tanar_tantargy.tanar_id = :tanar_id and tanar_tantargy.szak_id = :szak_id order by tantargy.nev"),
            array('tanar_id' => $tanar_id, 'szak_id' => $szak_id));
        foreach ($tantargyak as $tantargy) {
            array_push($tt, ['id' => $tantargy->id, 'nev' => $tantargy->nev]);
        }
        $tanar_tantargy = array_unique($tt, SORT_REGULAR);
        return response()->json(array('tantargyak' => $tanar_tantargy), 200);

    }

    function nincsEredmeny()
    {
        return view('nincsEredmeny');
    }

    public function statisztikaMegjelenit($tanar_id, $szak_id, $tantargy_id)
    {

    }



    public function statisztikaEgyeni()
    {
        session_start();
        if ($_POST['action'] == 'mehet') {
            $_SESSION['kivalasztott'] = $_POST['tanarok'];
            $tanar_id = $_POST['tanarok'];
            $szak_id = $_POST['szakok'];
            $tantargy_id = $_POST['tantargyak'];
            $szak = DB::select(DB::raw("select * from szak where id = :id"), array('id' => $szak_id));
            $tantargy = DB::select(DB::raw("select * from tantargy where id = :id"), array('id' => $tantargy_id));
            $funkcio = DB::select(DB::raw("select funkcio,statusz from tanar where id =:id order by nev"), array('id' => $_SESSION['tanar_id']));
            if ($funkcio[0]->statusz == 2) {
                $tanarok = DB::select(DB::raw("select * from tanar order by nev"));
            } else {
                if ($funkcio[0]->funkcio == 1) {
                    $tanarok = DB::select(DB::raw("select * from tanar where id =:id order by nev"), array('id' => $_SESSION['tanar_id']));

                } elseif ($funkcio[0]->funkcio == 2) {
                    $tanszek = DB::select(DB::raw("select tanszek from tanar where id =:id order by nev"), array('id' => $_SESSION['tanar_id']));
                    $tanarok = DB::select(DB::raw("select * from tanar where tanszek =:tanszek order by nev"), array('tanszek' => $tanszek[0]->tanszek));
                } elseif ($funkcio[0]->funkcio == 3) {
                    $tanarok = DB::select(DB::raw("select * from tanar order by nev"));
                }
            }
            if ($szak_id == 0 and $tantargy_id == 0) {
                $valaszok = DB::select(DB::raw("select format(avg(valasz),2) as atlag,kerdes,valasz1,valasz2,valasz3,valasz4,valasz5 from valaszok,kerdesek where tanar_id = :tanar_id and kerdesek.id = valaszok.kerdes_id group by kerdes_id;"),
                    array('tanar_id' => $tanar_id));
                $Osszatlag = DB::select(DB::raw("select format(avg(valasz),2) as atlag from valaszok where tanar_id = :tanar_id;"),
                    array('tanar_id' => $tanar_id));
                $kitoltesekSzama = DB::select(DB::raw("select count(DISTINCT (kerdoiv_id)) as ossz from valaszok where tanar_id = :tanar_id;"),
                    array('tanar_id' => $tanar_id));
            } elseif ($szak_id != 0 && $tantargy_id == 0) {
                $valaszok = DB::select(DB::raw("select format(avg(valasz),2) as atlag,kerdes,valasz1,valasz2,valasz3,valasz4,valasz5 from valaszok,kerdesek where tanar_id = :tanar_id and szak_id = :szak_id
                                and kerdesek.id = valaszok.kerdes_id group by kerdes_id;"),
                    array('tanar_id' => $tanar_id, 'szak_id' => $szak_id));
                $Osszatlag = DB::select(DB::raw("select format(avg(valasz),2) as atlag from valaszok where tanar_id = :tanar_id and szak_id = :szak_id;"),
                    array('tanar_id' => $tanar_id, 'szak_id' => $szak_id,));
                $kitoltesekSzama = DB::select(DB::raw("select count(DISTINCT (kerdoiv_id)) as ossz from valaszok where tanar_id = :tanar_id and szak_id = :szak_id;"),
                    array('tanar_id' => $tanar_id, 'szak_id' => $szak_id));
            } elseif ($szak_id != 0 && $tantargy_id != 0) {
                $valaszok = DB::select(DB::raw("select format(avg(valasz),2) as atlag,kerdes,valasz1,valasz2,valasz3,valasz4,valasz5 from valaszok,kerdesek where tanar_id = :tanar_id and szak_id = :szak_id
                                and tantargy_id = :tantargy_id and kerdesek.id = valaszok.kerdes_id group by kerdes_id;"),
                    array('tanar_id' => $tanar_id, 'szak_id' => $szak_id, 'tantargy_id' => $tantargy_id));
                $Osszatlag = DB::select(DB::raw("select format(avg(valasz),2) as atlag from valaszok where tanar_id = :tanar_id and szak_id = :szak_id and tantargy_id = :tantargy_id;"),
                    array('tanar_id' => $tanar_id, 'szak_id' => $szak_id, 'tantargy_id' => $tantargy_id));
                $kitoltesekSzama = DB::select(DB::raw("select count(DISTINCT (kerdoiv_id)) as ossz from valaszok where tanar_id = :tanar_id and szak_id = :szak_id and tantargy_id = :tantargy_id;"),
                    array('tanar_id' => $tanar_id, 'szak_id' => $szak_id, 'tantargy_id' => $tantargy_id));
            }

            if ($kitoltesekSzama[0]->ossz == 0) {
                return view('statisztika', ['tanarok' => $tanarok, 'tid' => $tanar_id, 'nincs' => 0]);
            } else if ($kitoltesekSzama[0]->ossz != 0) {
                return view('statisztika', ['valaszok' => $valaszok, 'atlag' => $Osszatlag[0]->atlag, 'hanyan' => $kitoltesekSzama[0]->ossz, 'tid' => $tanar_id, 'szak' => $szak, 'tanarok' => $tanarok, 'tantargy' => $tantargy]);
            }
        } elseif ($_POST['action'] == 'export') {
            $_SESSION['kivalasztott'] = $_POST['tanarok'];
            $tanar = $_POST['tanarok'];
            $szak = $_POST['szakok'];
            $t_id = $_POST['tantargyak'];

            $sz = DB::select(DB::raw("select * from szak where id = :id"), array('id' => $szak));
            $tantargy = DB::select(DB::raw("select * from tantargy where id = :id"), array('id' => $t_id));
            $funkcio = DB::select(DB::raw("select funkcio,statusz from tanar where id =:id order by nev"), array('id' => $_SESSION['tanar_id']));
            if ($funkcio[0]->statusz == 2) {
                $tanarok = DB::select(DB::raw("select * from tanar order by nev"));
            } else {
                if ($funkcio[0]->funkcio == 1) {
                    $tanarok = DB::select(DB::raw("select * from tanar where id =:id order by nev"), array('id' => $_SESSION['tanar_id']));

                } elseif ($funkcio[0]->funkcio == 2) {
                    $tanszek = DB::select(DB::raw("select tanszek from tanar where id =:id order by nev"), array('id' => $_SESSION['tanar_id']));
                    $tanarok = DB::select(DB::raw("select * from tanar where tanszek =:tanszek order by nev"), array('tanszek' => $tanszek[0]->tanszek));
                } elseif ($funkcio[0]->funkcio == 3) {
                    $tanarok = DB::select(DB::raw("select * from tanar order by nev"));
                }
            }
            if ($szak == 0 and $t_id == 0) {
                $valaszokExport = DB::select(DB::raw("select kerdes,format(avg(valasz),2) as atlag from valaszok,kerdesek where tanar_id = :tanar_id and kerdesek.id = valaszok.kerdes_id group by kerdes_id;"),
                    array('tanar_id' => $tanar));
                $atlag = DB::select(DB::raw("select format(avg(valasz),2) as atlag from valaszok where tanar_id = :tanar_id;"),
                    array('tanar_id' => $tanar));
                $kitoltesek = DB::select(DB::raw("select count(DISTINCT (kerdoiv_id)) as ossz from valaszok where tanar_id = :tanar_id;"),
                    array('tanar_id' => $tanar));
            } elseif ($szak != 0 && $t_id == 0) {
                $valaszokExport = DB::select(DB::raw("select kerdes,format(avg(valasz),2) as atlag from valaszok,kerdesek where tanar_id = :tanar_id and szak_id = :szak_id
                                and kerdesek.id = valaszok.kerdes_id group by kerdes_id;"),
                    array('tanar_id' => $tanar, 'szak_id' => $szak));
                $atlag = DB::select(DB::raw("select format(avg(valasz),2) as atlag from valaszok where tanar_id = :tanar_id and szak_id = :szak_id;"),
                    array('tanar_id' => $tanar, 'szak_id' => $szak,));
                $kitoltesek = DB::select(DB::raw("select count(DISTINCT (kerdoiv_id)) as ossz from valaszok where tanar_id = :tanar_id and szak_id = :szak_id;"),
                    array('tanar_id' => $tanar, 'szak_id' => $szak));
            } elseif ($szak != 0 && $t_id != 0) {
                $valaszokExport = DB::select(DB::raw("select kerdes,format(avg(valasz),2) as atlag from valaszok,kerdesek where tanar_id = :tanar_id and szak_id = :szak_id
                                and tantargy_id = :tantargy_id and kerdesek.id = valaszok.kerdes_id group by kerdes_id;"),
                    array('tanar_id' => $tanar, 'szak_id' => $szak, 'tantargy_id' => $t_id));
                $atlag = DB::select(DB::raw("select format(avg(valasz),2) as atlag from valaszok where tanar_id = :tanar_id and szak_id = :szak_id and tantargy_id = :tantargy_id;"),
                    array('tanar_id' => $tanar, 'szak_id' => $szak, 'tantargy_id' => $t_id));
                $kitoltesek = DB::select(DB::raw("select count(DISTINCT (kerdoiv_id)) as ossz from valaszok where tanar_id = :tanar_id and szak_id = :szak_id and tantargy_id = :tantargy_id;"),
                    array('tanar_id' => $tanar, 'szak_id' => $szak, 'tantargy_id' => $t_id));
            }

            if ($kitoltesek[0]->ossz == 0) {
                return view('statisztika', ['tanarok' => $tanarok, 'tid' => $tanar, 'nincs' => 0]);
            } else if ($kitoltesek[0]->ossz != 0) {

                $nev = DB::select(DB::raw("select nev from tanar where id = :id"), array('id' => $tanar));
                foreach ($valaszokExport as $valasz) {
                    $data[] = (array)$valasz;
                }

                array_push($data, ['atlag'=>$atlag[0]->atlag]);

                array_push($data, ['kitoltesekSzama' => $kitoltesek[0]->ossz]);
                if ($sz != null) {
                    array_push($data, ['szak' => @$sz[0]->szaknev]);
                } else {
                    array_push($data, ['szak' => 'Összes szak']);
                }
                if ($tantargy != null) {
                    array_push($data, ['tantargy' => @$tantargy[0]->nev]);

                } else {
                    array_push($data, ['tantargy' => 'Összes tantárgy']);
                }

                if (isset($_POST['kikuldes'])) { //ha kikuldjuk emailbe

                    $excelFile = Excel::create($nev[0]->nev, function ($excel) use ($data) {
                        $excel->sheet($data[count($data) - 2]['szak'], function ($sheet) use ($data) {
                            $sheet->cell('D1', function ($cell) {
                                $cell->setValue('Összesített átlag');
                                $cell->setBackground('#0066CC');
                                $cell->setFontColor('#ffffff');
                            });
                            $sheet->cell('D2', function ($cell) use ($data) {
                                $cell->setValue($data[count($data) - 4]['atlag']);
                                $cell->setBackground('#0066CC');
                                $cell->setFontColor('#ffffff');

                            });
                            $sheet->cell('E1', function ($cell) use ($data) {
                                $cell->setValue('Kitöltések száma');
                                $cell->setBackground('#336600');
                                $cell->setFontColor('#ffffff');

                            });
                            $sheet->cell('E2', function ($cell) use ($data) {
                                $cell->setValue($data[count($data) - 3]['kitoltesekSzama']);
                                $cell->setBackground('#336600');
                                $cell->setFontColor('#ffffff');

                            });

                            $sheet->cell('A1:E1', function ($cell) use ($data) {
                                $cell->setFont(array('bold' => true));

                            });
                            array_pop($data);
                            array_pop($data);
                            array_pop($data);
                            array_pop($data);
                            $sheet->cell('A2:')->fromArray($data);
                        });
                    });

                    $dataMail = array(
                        'name' => Input::get('Tanár - diák felmérő'),
                        'detail' => Input::get('detail'),
                        'sender' => Input::get('tttesttt994@gmail.com')
                    );

                    Mail::send('emailElkuldve', $dataMail, function ($message) use ($excelFile) {
                        $message->from('tttesttt994@gmail.com', 'Tanár - diák felmérő');

                        $message->to('zattila97@yahoo.com')->subject('Tanár - diák felmérő');

                        $message->attach($excelFile->store("xls", false, true)['full']);

                    });

                    return Redirect::to('emailElkuldveInfo');
                }elseif(!isset($_POST['kikuldes'])){
                    $excelFile = Excel::create($nev[0]->nev, function ($excel) use ($data) {
                        $excel->sheet($data[count($data) - 2]['szak'], function ($sheet) use ($data) {
                            $sheet->cell('D1', function ($cell) {
                                $cell->setValue('Összesített átlag');
                                $cell->setBackground('#0066CC');
                                $cell->setFontColor('#ffffff');
                            });
                            $sheet->cell('D2', function ($cell) use ($data) {
                                $cell->setValue($data[count($data) - 4]['atlag']);
                                $cell->setBackground('#0066CC');
                                $cell->setFontColor('#ffffff');

                            });
                            $sheet->cell('E1', function ($cell) use ($data) {
                                $cell->setValue('Kitöltések száma');
                                $cell->setBackground('#336600');
                                $cell->setFontColor('#ffffff');

                            });
                            $sheet->cell('E2', function ($cell) use ($data) {
                                $cell->setValue($data[count($data) - 3]['kitoltesekSzama']);
                                $cell->setBackground('#336600');
                                $cell->setFontColor('#ffffff');

                            });

                            $sheet->cell('A1:E1', function ($cell) use ($data) {
                                $cell->setFont(array('bold' => true));

                            });
                            array_pop($data);
                            array_pop($data);
                            array_pop($data);
                            array_pop($data);
                            $sheet->cell('A2:')->fromArray($data);
                        });
                    })->download('xls');
                }

            }
        }
    }


    public
    function statisztikaExport()
    {

    }

    public
    function emailKuldes()
    {

    }

    function emailElkuldve(){
        session_start();
        $tanar  = DB::select(DB::raw("select nev from tanar where id = :id"), array('id' => $_SESSION['kivalasztott']));
        return view('emailElkuldve',['tanar'=>$tanar[0]->nev]);
    }
    function emailElkuldveInfo(){
        return view('infoEmail');
    }


}
