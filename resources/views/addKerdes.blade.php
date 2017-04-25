<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kérdés hozzáadása</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="table">
    <div id="top">
        <h2>Új kérdés hozzáadása</h2>
        @if ($message = Session::get('siker'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('siker') }}
            </div>
        @endif
        @if ($message = Session::get('hiba'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('hiba') }}
            </div>
        @endif
    </div>
</div>

<div id="tanarAdatok">
    <form action="{{ URL::to('addKerdes') }}" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="labelDiv">
            <label>Kérdés</label>
            <input type="text" id="kerdes" contenteditable="true" name="kerdes"/>
        </div>
        <div class="labelDiv">
            <label>Válasz lehetőségek</label>
            <input type="text" id="valaszok" contenteditable="true" name="valaszok"/>
        </div>
        <button type="submit" id="hozzaad">Hozzáad</button>
    </form>
</div>
</body>