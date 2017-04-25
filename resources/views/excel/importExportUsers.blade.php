<html lang="en">
<head>
    <title>Tanárok kezelése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script>
        $(document).ready(function () {
            var tanar_id;
            $('#importDiak').click(function () {
                document.getElementById("popup").style.display = "block";
                $('body').addClass('stop-scrolling');
            });
            $('#megse').click(function () {
                document.getElementById('popup').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
            $('.torolTanar').click(function () {
                tanar_id = $(this).val();
                $('#tanID').val(tanar_id);
                $('html, body').animate({scrollTop: 0}, 'fast');
                document.getElementById('popupTorol').style.display = 'block';
                $('body').addClass('stop-scrolling');
            });
            $('#nem').click(function () {
                console.log(tanar_id);
                document.getElementById('popupTorol').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
        });
    </script>
</head>
<div id="orarendView">
    <div id="popup">
        <form action="importTanar" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <p class="popupTitle">Tanárok feltöltése</p>
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
                <form action="torolTanar" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="tanID" id="tanID" value="0">
                    <button id="igen">Törlés</button>
                    <button id="nem" type="button">Mégse</button>
                </form>

            </div>
        </div>
    </div>
    <form id="tanarUpdate">
        <div class="buttons">
            <table>
                <tr>
                    <td>
                        <div class="selector">
                            <div id="uploadTanar">
                                <button id="importDiak" type="button">Importálás</button>
                                <span id="tanarSpan">Tanárok feltöltése</span>
                            </div>
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
                    </td>
                    <td>
                        <div class="selector">
                            <div id="exportTanar">
                                <a href="{{ url('exportTanar') }}">
                                    <button type="button">Exportálás</button>
                                </a>
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
            <span class="fejlecBalTanar">Név</span>
            <span class="fejlecBalTanar">Tanszék</span>
            <span class="fejlecBalTanar">Fokozat</span>
            <span class="fejlecBalTanar">E-mail</span>
        </div>
        @foreach($tanarok as $tanar)
            <div class="tanar">
                <button class="torolTanar" style="float: right;" value={{$tanar->id}}><span>Töröl</span>
                </button>
                <form action="modositTanar" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
                    <span class="tanGomb">
                    <div class="modositGombok">
                        <input type="hidden" name="tanar_id" value={{ $tanar->id }}>
                        <button id="modositTanar"><span>Módosít</span></button>
                         </div>
                    </span>
                </form>

                <div style="width: 300px; float: left">
                    <span class="tan"><b>@if($tanar->nev == NULL) - @else{{$tanar->nev}} @endif</b></span>
                </div>
                <div style="width: 250px; float: left">
                    <span class="tanszek"><b>@if($tanar->tanszek == NULL) - @else{{$tanar->tanszek}} @endif</b></span>
                </div>
                <div style="width: 250px; float: left">
                    <span class="tan"><b>@if($tanar->fokozat == NULL) - @else{{$tanar->fokozat}} @endif</b></span>
                </div>
                <div style="width: 250px; float: left">
                    <span class="tan"><b>@if($tanar->email == NULL) - @else{{$tanar->email}} @endif</b></span>
                </div>

            </div>
        @endforeach
        <div class="fejlec">
            <span class="ujTanGomb"><a href="addTanar" target="container2" id="hozzaadas">Új tanár hozzáadása</a></span>
        </div>
    </div>
</div>

</body>


</html>