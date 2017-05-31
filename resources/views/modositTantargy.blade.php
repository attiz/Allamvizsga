<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Tantárgy modosítása</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#szerkesztes').click(function () {
                document.getElementById("mentes").style.display = "block";
            });
        });
    </script>
</head>
<body>
<div id="table">
    <div id="top">
        <h2>Tantárgy módosítása</h2>
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
    <form action="modositTantargyAdatok" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" id="profilMentes" value="ment" name="profilMentes"/>
        <input type="hidden" id="ora_id" value={{$adatok[0]->id}} name="ora_id"/>
        <input type="hidden" id="szak_id" value={{$adatok[0]->szak}} name="szak_id"/>
        <div class="labelDiv">
            <label>Tantárgy</label>
            <select name="tantargy" class="modositTantargy" readonly>
                <option value={{$adatok[0]->tantargy_id}}>{{$adatok[0]->nev}}</option>
            </select>
        </div>
        <div class="labelDiv">
            <label>Tanár</label>
            <select name="tanar" class="modositTantargy" readonly>
                @foreach($tanarok as $tanar)
                    @if($adatok[0]->tanar_id == $tanar->id)
                        <option value={{$tanar->id}} selected>{{$tanar->nev}}</option>
                    @else
                        <option value={{$tanar->id}}>{{$tanar->nev}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <button type="submit" id="mentes">Mentés</button>
    </form>
</div>
</body>