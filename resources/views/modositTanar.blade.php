<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Tanárok modosítása</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#szerkesztes').click(function () {
                $("#nev").attr("readonly", false);
                $("#fokozat").attr("readonly", false);
                $("#email").attr("readonly", false);
                $("#profilMentes").attr('value', 'ment');
                document.getElementById("szerkesztes").style.display = "none";
                document.getElementById("mentes").style.display = "block";
                $("#selectTanszek").removeAttr('disabled');
                $("#selectFokozat").removeAttr('disabled');
                $("#selectFunkcio").removeAttr('disabled');
            });
        });
    </script>
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
    <form action="modositTanarAdatok" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" id="profilMentes" value="0" name="profilMentes"/>
        <input type="hidden" id="tanar_id" value={{$adatok[0]->id}} name="tanar_id"/>
        <div class="labelDiv">
            <label>Név</label>
            <input type="text" id="nev" name="nev" readonly value="{{$adatok[0]->nev}}"/>
        </div>
        <div class="labelDiv">
            <label>Tanszék</label>
            <select name="tanszek" id="selectTanszek" disabled>
                @if($adatok[0]->tanszek == NULL)
                    <option value="0" disabled selected>Válasszon tanszéket</option>
                @endif
                @foreach($tanszekek as $tanszek)
                    @if($adatok[0]->tanszek == $tanszek->id)
                        <option value={{$tanszek->id}} selected>{{$tanszek->nev}}</option>
                    @else
                        <option value={{$tanszek->id}} >{{$tanszek->nev}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="labelDiv">
            <label>Fokozat</label>
            <select name="fokozat" id="selectFokozat" disabled>
                @if($adatok[0]->fokozat == NULL)
                    <option value="0" disabled selected>Válasszon fokozatot</option>
                @endif
                @foreach($fokozatok as $fokozat)
                    @if($adatok[0]->fokozat == $fokozat->id)
                        <option value={{$fokozat->id}} selected>{{$fokozat->fokozat}}</option>
                    @else
                        <option value={{$fokozat->id}} >{{$fokozat->fokozat}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="labelDiv">
            <label>Email</label>
            <input type="text" id="email" name="email" readonly value="{{$adatok[0]->email}}"/>
        </div>
        <div class="labelDiv">
            <label>Funkció</label>
            <select name="funkcio" id="selectFunkcio" disabled>
                @foreach($funkcio as $key => $value)
                    @if ($adatok[0]->funkcio == $value)
                        <option value={{$value}} selected>{{$key}}</option>
                    @else

                        <option value={{$value}} >{{$key}}</option>
                    @endif
                @endforeach
            </select>

        </div>
        <input type="button" id="szerkesztes" value="Szerkesztés"></inputbutton>
        <button type="submit" id="mentes" style="display: none">Mentés</button>
    </form>
</div>
</body>