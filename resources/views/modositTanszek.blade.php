<html lang="en">
<head>
    <title>Tanárok frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#szerkesztes').click(function () {
                $("#tanszek").attr("readonly", false);
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
        <h2>Tanszék módosítása</h2>
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
    <form action="modositTanszekAdatok" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" id="tanszek_id" value={{$adatok[0]->id}} name="tanszek_id"/>
        <input type="hidden" id="profilMentes" value="0" name="profilMentes"/>
        <div class="labelDiv">
            <label>Tanszék</label>
            <input type="text" id="tanszek" contenteditable="true" name="tanszek" readonly value="{{$adatok[0]->nev}}"/>
        </div>
        <input type="button" id="szerkesztes" value="Szerkesztés"></inputbutton>
        <button type="submit" id="mentes" style="display: none">Mentés</button>
    </form>
</div>
</body>

</html>