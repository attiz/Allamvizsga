<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Tanárok modosítása</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
</head>
<body>
<div id="table">
    <div id="top">
        <h2>Tanár módosítása</h2>
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
    <form action="addTanar" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="labelDiv">
            <label>Név</label>
            <input type="text" id="nev" name="nev" value=""/>
        </div>
        <div class="labelDiv">
            <label>Tanszék</label>
            <select name="tanszek" id="selectTanszek">
                <option value="0" disabled selected>Válasszon tanszéket</option>
                @foreach($tanszekek as $tanszek)
                    <option value={{$tanszek->id}} >{{$tanszek->nev}}</option>
                @endforeach
            </select>
        </div>
        <div class="labelDiv">
            <label>Fokozat</label>
            <select name="fokozat" id="selectFokozat">
                <option value="0" disabled selected>Válasszon fokozatot</option>
                @foreach($fokozatok as $fokozat)

                    <option value={{$fokozat->id}} >{{$fokozat->fokozat}}</option>

                @endforeach
            </select>
        </div>
        <div class="labelDiv">
            <label>Email</label>
            <input type="text" id="email" name="email" value=""/>
        </div>
        <div class="labelDiv">
            <label>Funkció</label>
            <select name="funkcio" id="selectFunkcio">
                @foreach($funkcio as $key => $value)
                    <option value={{$value}} >{{$key}}</option>
                @endforeach
            </select>

        </div>
        <button type="submit" id="mentes">Hozzáad</button>
    </form>
</div>
</body>