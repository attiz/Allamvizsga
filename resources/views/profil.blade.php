<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Profil megtekintése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#szerkesztes').click(function () {
                $("#nev").attr("readonly", false);
                $("#felhasznalo").attr("readonly", false);
                $("#tanszek").attr("readonly", false);
                $("#fokozat").attr("readonly", false);
                $("#email").attr("readonly", false);
                $("#selectTanszek").removeAttr('disabled');
                $("#profilMentes").attr('value', 'ment');
                document.getElementById("szerkesztes").style.display = "none";
                document.getElementById("mentes").style.display = "block";
            });
        });
    </script>
</head>
<body>
<div id="table">
    <div id="top">
        <h2>Profil megtekintése</h2>
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
    <form action="modositProfil" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden"  id="profilMentes" value="0" name="profilMentes"/>
        <div class="labelDiv">
            <label>Név</label>
            <input type="text" id="nev" name="nev" readonly value="{{$adatok[0]->nev}}"/>
        </div>
        <div class="labelDiv">
            <label>Felhasználónév</label>
            <input type="text" id="felhasznalo" name="felhasznalo" readonly value="{{$adatok[0]->felhasznalo}}"/>
        </div>
        <div class="labelDiv">
            <label>Tanszék</label>
            <select name="tanszek" id="selectTanszek" disabled>
                @foreach($tanszekek as $tanszek)
                    @if($adatok[0]->tanszek == $tanszek->id)
                        <option value={{$tanszek->id}} selected >{{$tanszek->nev}}</option>
                    @else
                        <option value={{$tanszek->id}} >{{$tanszek->nev}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="labelDiv">
            <label>Fokozat</label>
            <input type="text" id="fokozat" name="fokozat" readonly value="{{$adatok[0]->fokozat}}"/>
        </div>
        <div class="labelDiv">
            <label>Email</label>
            <input type="text" id="email" name="email" readonly value="{{$adatok[0]->email}}"/>
        </div>
        <input type="button" id="szerkesztes" value="Szerkesztés"></inputbutton>
        <button type="submit" id="mentes" style="display: none">Mentés</button>
    </form>
</div>
</body>