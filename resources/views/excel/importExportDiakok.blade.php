<html lang="en">
<head>
    <title>Tanárok frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#importDiak').click(function () {
                document.getElementById("popup").style.display = "block";
                $('body').addClass('stop-scrolling');
            });
            $('#megse').click(function () {
                document.getElementById('popup').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
        });
    </script>
</head>
<body>
<div id="diakok">
    <div id="popup">
        <form action="importDiak" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <p class="popupTitle">Diákok feltöltése</p>
            <div class="popupButtonContainer">
                <input type="file" name="import_file" id="import_file">
                <button>Feltöltés</button>
                {{ csrf_field() }}
                <button type="button" id="megse">Mégse</button>
            </div>
        </form>
    </div>
    <form id="importDiakok">
        <div class="buttons">
            <table>
                <tr>
                    <td>
                        <div class="selector">
                            <div id="uploadTantargy">
                                <button id="importDiak" type="button">Importálás</button>
                                {{ csrf_field() }}
                                <span id="tanarSpan">Diákok feltöltése</span>
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                                @if ($message = Session::get('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ Session::get('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="selector">
                            <div id="uploadOrak">
                                <a href="{{ url('exportDiak') }}">
                                    <button type="button">Exportálás</button>
                                </a>
                                <span id="tanarSpan">Diákok exportálása</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
<div id="table">
    <div id="top">
        <h2>Új diák hozzáadása</h2>
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
    <form action="{{ URL::to('addDiak') }}" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="labelDiv">
            <label>Neptun kód</label>
            <input type="text" id="neptunkod" contenteditable="true" name="neptunkod"/>
        </div>
        <button type="submit" id="hozzaad">Hozzáad</button>
    </form>
</div>
</body>

</html>