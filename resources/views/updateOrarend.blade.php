<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Órarend kezelése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#importTantargy').click(function () {
                document.getElementById("popup").style.display = "block";
                $('body').addClass('stop-scrolling');
            });
            $('#importOsztaly').click(function () {
                document.getElementById("popup2").style.display = "block";
                $('body').addClass('stop-scrolling');
            });
            $('#importOrak').click(function () {
                document.getElementById("popup3").style.display = "block";
                $('body').addClass('stop-scrolling');
            });
            $('#megse').click(function () {
                document.getElementById('popup').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
            $('#megse2').click(function () {
                document.getElementById('popup2').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
            $('#megse3').click(function () {
                document.getElementById('popup3').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
            $('.torolTanar').click(function () {
                ora_id = $(this).val();
                $('#oraID').val(ora_id);
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
<div id="orarendView">
    <div id="popup">
        <form action="feltoltTantargy" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <p class="popupTitle">Tantárgyak feltöltése</p>
            <div class="popupButtonContainer">
                <input type="file" name="import_tantargy" id="import_tantargy">
                <button>Feltöltés</button>
                {{ csrf_field() }}
                <button type="button" id="megse">Mégse</button>
            </div>
        </form>
    </div>
    <div id="popup2">
        <form action="feltoltOsztaly" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <p class="popupTitle">Osztályok feltöltése</p>
            <div class="popupButtonContainer">
                <input type="file" name="import_osztaly" id="import_osztaly">
                <button>Feltöltés</button>
                {{ csrf_field() }}
                <button type="button" id="megse2">Mégse</button>
            </div>
        </form>
    </div>
    <div id="popup3">
        <form action="feltoltOrak" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <p class="popupTitle">Órák feltöltése</p>
            <div class="popupButtonContainer">
                <input type="file" name="import_orak" id="import_orak">
                <button>Feltöltés</button>
                {{ csrf_field() }}
                <button type="button" id="megse3">Mégse</button>
            </div>
        </form>
    </div>
    <div id="popupTorol">
        <div id="torles">
            <p class="popupTitle">Biztosan törli?</p>
            <div class="popupButtonContainer">
                <form action="torolOra" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="oraID" id="oraID" value="0">
                    <button id="igen">Törlés</button>
                    <button id="nem" type="button">Mégse</button>
                </form>

            </div>
        </div>
    </div>
    <form id="orarendUpdate">
        <div class="buttons">
            <table>
                <tr>
                    <td>
                        <div class="selector">
                            <div id="uploadTantargy">
                                <button id="importTantargy" type="button">Importálás</button>
                                <span id="tanarSpan">Tantárgyak feltöltése</span>
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
                            <div id="uploadOsztályok">
                                <button id="importOsztaly" type="button">Importálás</button>
                                <span id="tanarSpan">Osztályok feltöltése</span>
                                @if ($message = Session::get('success2'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('success2') }}
                                    </div>
                                @endif
                                @if ($message = Session::get('error2'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ Session::get('error2') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="selector">
                            <div id="uploadOrak">
                                <button id="importOrak" type="button">Importálás</button>
                                <span id="tanarSpan">Órák feldolgozása</span>
                                @if ($message = Session::get('success3'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('success3') }}
                                    </div>
                                @endif
                                @if ($message = Session::get('error3'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ Session::get('error3') }}
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
<div id="div1">
    {{Form::open(array('url' => 'showOrarend','method' => 'POST'))}}
    <span>Szak</span>

    <select name="szakok" id="szakok">
        @if (isset($szak))
            @foreach($szakok as $sz)
                @if($szak == $sz->id)
                    <option value={{$sz->id}} selected>{{$sz->szaknev}}</option>
                @else
                    <option value={{$sz->id}}>{{$sz->szaknev}}</option>
                @endif
            @endforeach
        @else
            @foreach($szakok as $sz)
                <option value={{$sz->id}}>{{$sz->szaknev}}</option>
            @endforeach
        @endif
    </select>
    <span style="padding-left: 10px;">Félév</span>
    @if(isset($felev))
        <select id="felev" name="felev">
            @if ($felev == 1)
                <option class="fel" value=1 selected>I.</option>
                <option class="fel" value=2>II.</option>
            @else
                <option class="fel" value=1>I.</option>
                <option class="fel" value=2 selected>II.</option>
            @endif
        </select>
    @else
        <select id="felev" name="felev">
            <option class="fel" value=1>I.</option>
            <option class="fel" value=2>II.</option>
        </select>
    @endif
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
                    <button class="torolTanar" style="float: right;" value={{$ora->id}}><span>Töröl</span>
                    </button>
                    <form action="modositTantargy" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                        <span class="tanGomb">
                    <div class="modositGombok">
                        <input type="hidden" name="ora_id" value={{ $ora->id }}>
                        <button id="modositTanar"><span>Módosít</span></button>
                         </div>
                    </span>
                    </form>
                    <div style="width: 500px; float: left">
                        <span class="tanOrarend"><b>{{$ora->tantargy}}</b></span>
                    </div>
                    <div>
                        <span class="tan"><b>{{$ora->nev}}</b></span>
                    </div>
                </div>
            @endforeach
            <div class="fejlec">
                <span class="ujTanGomb"><a href="addOra" target="container2"
                                           id="hozzaadas">Új rekord hozzáadása</a></span>
            </div>


        </div>
    </div>
@endif

</body>