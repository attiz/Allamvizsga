<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Question;
use Excel;
use Illuminate\Support\Facades\Input;

class QuestionController extends Controller
{
    public function showView()
    {
        return view('excel.importExportQuestions');
    }

    public function importQuestions(Request $request)
    {
        if($request->hasFile('import_file')){
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function($reader) {})->get();

            if(!empty($data) && $data->count()){

                foreach ($data->toArray() as $key => $value) {
                    if(!empty($value)){
                        foreach ($value as $v) {
                            $insert[] = ['question' => $v['question']];
                        }
                    }
                }

                if(!empty($insert)){
                    Question::insert($insert);
                    return back()->with('success','Sikeres!');
                }
            }
        }
        return back()->with('error','Valasszon ki egy fajlt!');
    }

    public function exportQuestions(Request $request)
    {
        $data = Question::get()->toArray();
        return Excel::create('questions', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download();
    }

    public function addQuestion(Request $request){
        $question = new question;
        $question -> question = Input::get("question");

        $question->save();

        return back()->with('success','Sikeres hozzaadas!');

    }
}
