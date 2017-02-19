<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Statisztika extends Controller
{
    public function getTantargyak(){
        $tantargyak = array();
        $kerdesek = array();
        $valaszok=array();
        $adatok = DB::select( DB::raw("select kerdes_id,tantargy_id, avg(valasz) as atlag from valaszok group by kerdes_id,tantargy_id"));
        foreach ($adatok as $data) {
            array_push($kerdesek, $data->kerdes_id);
            array_push($tantargyak, $data->tantargy_id);
            array_push($valaszok, $data->atlag);
        }
        $chartjs = app()->chartjs
            ->name('Tantargyak Statisztikaja')
            ->type('line')
            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'])
            ->datasets([
                [
                    "label" => "My First dataset",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [65, 59, 80, 81, 56, 55, 40],
                ],
                [
                    "label" => "My Second dataset",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [12, 33, 44, 44, 55, 23, 40],
                ]
            ])
            ->options([]);
        return view('statisztika',compact('chartjs'));
    }
}
