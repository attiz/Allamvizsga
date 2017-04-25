<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Tanárok frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#frissites').click(function () {
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
<div id="tanarView">
    <div id="popup">
        <form action="frissitTanar" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <p class="popupTitle">Tanárok frissítése</p>
            <div class="popupButtonContainer">
                <input type="file" name="import_file" id="import_file">
                <button>Frissítés</button>
                {{ csrf_field() }}
                <button type="button" id="megse">Mégse</button>
            </div>
        </form>
    </div>
    <form id="tanarUpdate">
        <div class="buttons">
            <table>
                <tr>
                    <td>
                        <div class="selector">
                            <input id="inputText" class="textbox" type="text" placeholder="Tanár neve">
                            <button type="submit" id="tanarSzures">Szűrés</button>
                        </div>
                    </td>
                    <td>
                        <div class="selector">
                            <div id="uploadTanar">
                                <button id=frissites type="button">Importálás</button>
                                <span id="tanarSpan">Tanárok adatainak frissítése</span>
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
                </tr>
            </table>
        </div>
    </form>
</div>
<div id="tanarAdatok">
    <div class="labelDiv">
        <label>Név</label>
        <input type="text" id="nev" contenteditable="true"/>
    </div>
    <div class="labelDiv">
        <label>Tanszék</label>
        <input type="text" id="tanszek" contenteditable="true"/>
    </div>
    <div class="labelDiv">
        <label>Funkció</label>
        <input type="text" id="funkcio" contenteditable="true"/>
    </div>
    <div class="labelDiv">
        <label>Email</label>
        <input type="text" id="email" contenteditable="true"/>
    </div>
    <button type="submit" id="mentes">Mentés</button>
</div>
</body>