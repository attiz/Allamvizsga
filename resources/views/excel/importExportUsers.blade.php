<html lang="en">
<head>
    <title>Tanárok kezelése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
</head>

{{--<body>--}}
{{--<h3>Import Users from Excel file</h3>--}}
{{--@if ($message = Session::get('success'))--}}
{{--<div class="alert alert-success" role="alert">--}}
{{--{{ Session::get('success') }}--}}
{{--</div>--}}
{{--@endif--}}

{{--@if ($message = Session::get('error'))--}}
{{--<div class="alert alert-danger" role="alert">--}}
{{--{{ Session::get('error') }}--}}
{{--</div>--}}
{{--@endif--}}

{{--<form action="{{ URL::to('importTanar') }}" method="post" enctype="multipart/form-data">--}}
{{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
{{--<input type="file" name="import_file" />--}}
{{--{{ csrf_field() }}--}}
{{--<br/>--}}
{{--<button>Import Excel File</button>--}}
{{--</form>--}}
{{--<br/>--}}

{{--<h3>Export Users from database</h3>--}}
{{--<div>--}}
{{--<a href="{{ url('exportTanar') }}"><button>Export</button></a>--}}
{{--</div>--}}
<div id="orarendView">
    <form id="tanarUpdate">
        <div class="buttons">
            <table>
                <tr>
                    <td>
                        <div class="selector">
                            <div id="uploadTanar">
                                <button id="1" type="button">Importálás</button>
                                <span id="tanarSpan">Tanárok feltöltése</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="selector">
                            <div id="exportTanar">
                                <button id="1" type="button">Exportálás</button>
                                <span id="tanarSpan">Tanárok exportálása</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="selector">
                            <div id="updateTanar">
                                <button id="1" type="button"
                                        onclick="window.open('updateTanar','container2','resizable=yes')">Frissítés
                                </button>
                                <span id="tanarSpan">Tanárok adatainak frissítése</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>

<div class="classContainer">
    <div class="kerdesek">
        <div class="fejlec">
            <span class="fejlecBal">Név</span>
            <span class="fejlecBal">Tanszék</span>
            <span class="fejlecBal">Fokozat</span>
            <span class="fejlecBal">E-mail</span>
        </div>
        @foreach($tanarok as $tanar)
            <div class="tanar">
                <span class="tanGomb"><a href="addTanar" target="container2" id="modosit" value={{$tanar->id}}>Módosít</a></span>
                <span class="tan"><b>{{$tanar->nev}}</b></span>
                <span class="tan"><b>{{$tanar->tanszek}}</b></span>
                <span class="tan"><b>{{$tanar->fokozat}}</b></span>

            </div>
        @endforeach
        <div class="fejlec">
            <span class="tanGomb"><a href="addTanar" target="container2" id="hozzaadas">Új tanár hozzáadása</a></span>
        </div>
    </div>
</div>

</body>


</html>