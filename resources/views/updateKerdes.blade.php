<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kérdések frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script>
        $(document).ready(function () {
            var kerdes_id;
            $('#importKerdes').click(function () {
                document.getElementById("popup").style.display = "block";
                $('body').addClass('stop-scrolling');
            });
            $('#megse').click(function () {
                document.getElementById('popup').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
            $('.torolTanar').click(function () {
                kerdes_id = $(this).val();
                $('#kerID').val(kerdes_id);
                $('html, body').animate({scrollTop: 0}, 'fast');
                document.getElementById('popupTorol').style.display = 'block';
                $('body').addClass('stop-scrolling');
            });
            $('#nem').click(function () {
                document.getElementById('popupTorol').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
        });
    </script>
</head>
<body>
<div id="kerdesek">
    <div id="popup">
        <form action="importKerdesek" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <p class="popupTitle">Kérdések feltöltése</p>
            <div class="popupButtonContainer">
                <input type="file" name="import_file" id="import_file">
                <button>Feltöltés</button>
                {{ csrf_field() }}
                <button type="button" id="megse">Mégse</button>
            </div>
        </form>
    </div>
    <div id="popupTorol">
        <div id="torles">
            <p class="popupTitle">Biztosan törli?</p>
            <div class="popupButtonContainer">
                <form action="torolKerdes" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="kerID" id="kerID" value="0">
                    <button id="igen">Törlés</button>
                    <button id="nem" type="button">Mégse</button>
                </form>

            </div>
        </div>
    </div>
    <form id="kerdesUpdate">
        <div class="buttons">
            <table>
                <tr>
                    <td>
                        <div class="selector">
                            <div id="uploadKerdes">
                                <button id="importKerdes" type="button">Importálás</button>
                                <span id="tanarSpan">Kérdések feltöltése</span>
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
                                <a href="{{ url('exportKerdesek') }}">
                                    <button id="1" type="button">Exportálás</button>
                                </a>
                                <span id="tanarSpan">Kérdések exportálása</span>
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
            <div class="kerdesDiv">
                <button class="torolTanar" style="float: right;" value={{$kerdes->id}}><span>Töröl</span>
                </button>
                <form action="modositKerdes" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <span class="tanGomb">
                    <div class="modositGombok">
                        <input type="hidden" name="kerdes_id" value={{ $kerdes->id }}>
                        <button id="modositTanar"><span>Módosít</span></button>
                         </div>
                    </span>
                </form>
                    <span class="kerdesSpan"><b>{{$kerdes->kerdes}}</b></span>

            </div>
        @endforeach
        <div class="fejlec">
            <span class="ujTanGomb"><a href="addKerdes" target="container2"
                                       id="hozzaadas">Új kérdés hozzáadása</a></span>
        </div>

    </div>
</div>

</body>