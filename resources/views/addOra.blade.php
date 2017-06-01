<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Órarend frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="table">
    <div id="top">
        <h2>Új óra hozzáadása</h2>
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
<form action="addOraAdatok" method="post">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <div id="tanarAdatok">
        <div class="labelDiv">
            <label>Szak</label>
            <select name="szak" class="modositTantargy">
                @foreach($szakok as $szak)
                    <option value={{$szak->id}}>{{$szak->szaknev}}</option>
                @endforeach
            </select>
        </div>
        <div class="labelDiv">
            <label>Tantárgy</label>
            <select name="tantargy" class="modositTantargy">
                @foreach($tantargyak as $tantargy)
                    <option value={{$tantargy->id}}>{{$tantargy->nev}}</option>
                @endforeach
            </select>
        </div>
        <div class="labelDiv">
            <label>Tanár</label>
            <select name="tanar" class="modositTantargy">
                @foreach($tanarok as $tanar)
                    <option value={{$tanar->id}}>{{$tanar->nev}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" id="hozzaad">Hozzáad</button>
    </div>
</form>
</body>