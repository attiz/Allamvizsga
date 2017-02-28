<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kerdes;
use Excel;
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

    public function addKerdes(Request $request){
        $question = new kerdes;
        $question -> kerdes = Input::get("question");

        $question->save();

        return back()->with('success','Sikeres hozzaadas!');

    }
}
