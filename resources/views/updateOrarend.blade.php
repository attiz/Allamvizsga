<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Órarend kezelése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="orarendView">
    <form id="orarendUpdate">
        <div class="buttons">
            <table>
                <tr>
                    <td>
                        <div class="selector">
                            <div id="uploadTantargy">
                                <button id="1" type="button">Importálás</button>
                                <span id="tanarSpan">Tantárgyak feltöltése</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="selector">
                            <div id="uploadOsztályok">
                                <button id="1" type="button">Importálás</button>
                                <span id="tanarSpan">Osztályok feltöltése</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="selector">
                            <div id="uploadOrak">
                                <button id="1" type="button">Importálás</button>
                                <span id="tanarSpan">Órák feldolgozása</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
<div id="div1">
    {{Form::open(array('url' => 'showOrarend','method' => 'POST'))}}
    <span>Szak</span>

    <select name="szakok">
        @foreach($szakok as $szak)
            <option value={{$szak->id}}>{{$szak->szaknev}}</option>
        @endforeach
    </select>

    <button type="submit" id="orarend">Mehet</button>
    {{Form::close()}}
</div>
@if (isset($orarend))
    <div class="classContainer">
        <div class="kerdesek">
            <div class="fejlec">
                <span class="fejlecBal">Tantárgy</span>
                <span class="fejlecBalOrarend">Tanár</span>
            </div>
            @foreach($orarend as $ora)
                <div class="tanar">
                    <span class="tanGomb"><a href="addTanar" target="container2" id="modosit">Módosít</a></span>
                    <div style="width: 500px; float: left">
                        <span id="tantargySpan"><b>{{$ora->tantargy}}</b></span>
                    </div>
                    <div>
                        <span id="tanar"><b>{{$ora->nev}}</b></span>
                    </div>
                </div>
            @endforeach
            <div class="fejlec">
                <span class="tanGomb"><a href="addTanar" target="container2" id="hozzaadas">Új rekord hozzáadása</a></span>
            </div>


        </div>
    </div>
@endif

</body>