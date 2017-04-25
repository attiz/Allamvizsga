<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kérdés módosítása</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#szerkesztes').click(function () {
                $("#kerdes").attr("readonly", false);
                $("#valaszok").attr("readonly", false);
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
        <h2>Kérdés módosítása</h2>
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
    <form action="modositKerdesAdatok" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden"  id="kerdes_id" value={{$adatok[0]->id}} name="kerdes_id"/>
        <input type="hidden"  id="profilMentes" value="0" name="profilMentes"/>
        <div class="labelDiv">
            <label>Kérdés</label>
            <input type="text" id="kerdes" name="kerdes" readonly value="{{$adatok[0]->kerdes}}"/>
        </div>
        <div class="labelDiv">
            <label>Válasz lehetőségek</label>
            <input type="text" id="valaszok" name="valaszok" readonly value="{{$adatok[0]->valasz}}"/>
        </div>
        <input type="button" id="szerkesztes" value="Szerkesztés"></inputbutton>
        <button type="submit" id="mentes" style="display: none">Mentés</button>
    </form>
</div>
</body>