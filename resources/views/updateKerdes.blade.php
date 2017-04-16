<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kérdések frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="kerdesek">
    <form id="kerdesUpdate">
        <div class="buttons">
            <table>
                <tr>
                    <td>
                        <div class="selector">
                            <div id="uploadKerdes">
                                <button id="1" type="button">Importálás</button>
                                <span id="tanarSpan">Kérdések feltöltése</span>
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
            <span class="fejlecBal">Kérdés</span>
        </div>
        @foreach($kerdesek as $kerdes)
            <div class="tanar">
                <span class="tanGomb"><a href="addTanar" target="container2" id="modosit">Módosít</a></span>
                <span class="tan"><b>{{$kerdes->kerdes}}</b></span>
            </div>
        @endforeach
        <div class="fejlec">
            <span class="tanGomb"><a href="addTanar" target="container2" id="hozzaadas">Új kérdés hozzáadása</a></span>
        </div>

    </div>
</div>

</body>