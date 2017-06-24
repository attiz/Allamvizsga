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
            $('#szerkesztes').click(function () {
                $("#nev").attr("readonly", false);
                $("#tanszek").attr("readonly", false);
                $("#fokozat").attr("readonly", false);
                $("#email").attr("readonly", false);
                $("#selectTanszek").removeAttr('disabled');
                $("#selectFokozat").removeAttr('disabled');
                $("#profilMentes").attr('value', 'ment');
                document.getElementById("szerkesztes").style.display = "none";
                document.getElementById("mentes").style.display = "block";
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
    <div id="tanarUpdate">
        <div class="buttons">
            <table>
                <tr>
                    <td>
                        <div class="selector">
                            <form action="modositTanarSzures" method="post">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <div class="ui-widget">
                                    <select name="tanarok" id="tanarokSelect">
                                        <option value="" disabled selected>Tanár neve</option>
                                        @if(isset($kivalasztott))
                                            @foreach($tanarok as $tanar)
                                                @if($kivalasztott == $tanar->id )
                                                    <option value={{$tanar->id}} selected>{{$tanar->nev}}</option>
                                                @else
                                                    <option value={{$tanar->id}}>{{$tanar->nev}}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($tanarok as $tanar)
                                                <option value={{$tanar->id}}>{{$tanar->nev}}</option>
                                            @endforeach
                                        @endif
                                    </select>
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
                                    <button type="submit" id="tanarSzures">Szűrés</button>
                                </div>
                            </form>
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
    </div>
</div>
<div id="table">
    <div id="top">
        <h2>Tanár módosítása</h2>
    </div>
</div>
@if(isset($adatok))
    <form action="modositTanarAdatokSzures" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="profilMentes" value="0" name="profilMentes"/>
        <input type="hidden" id="tanar_id" value={{$adatok[0]->id}} name="tanar_id"/>
        <div id="tanarAdatok">
            <div class="labelDiv">
                <label>Név</label>
                <input type="text" id="nev" name="nev" readonly value="{{$adatok[0]->nev}}"/>
            </div>
            <div class="labelDiv">
                <label>Tanszék</label>
                <select name="tanszek" id="selectTanszek" disabled>
                    @if($adatok[0]->tanszek == NULL)
                        <option value="0" disabled selected>Válasszon tanszéket</option>
                    @endif
                    @foreach($tanszekek as $tanszek)
                        @if($adatok[0]->tanszek == $tanszek->id)
                            <option value={{$tanszek->id}} selected>{{$tanszek->nev}}</option>
                        @else
                            <option value={{$tanszek->id}} >{{$tanszek->nev}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="labelDiv">
                <label>Fokozat</label>
                <select name="fokozat" id="selectFokozat" disabled>
                    @if($adatok[0]->fokozat == NULL)
                        <option value="0" disabled selected>Válasszon fokozatot</option>
                    @endif
                    @foreach($fokozatok as $fokozat)
                        @if($adatok[0]->fokozat == $fokozat->id)
                            <option value={{$fokozat->id}} selected>{{$fokozat->fokozat}}</option>
                        @else
                            <option value={{$fokozat->id}} >{{$fokozat->fokozat}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="labelDiv">
                <label>Email</label>
                <input type="text" id="email" name="email" readonly value="{{$adatok[0]->email}}"/>
            </div>
            <div class="labelDiv">
                <label>Funkció</label>
                <select name="funkcio" id="selectFunkcio" disabled>
                    @foreach($funkcio as $key => $value)
                        @if ($adatok[0]->funkcio == $value)
                            <option value={{$value}} selected>{{$key}}</option>
                        @else

                            <option value={{$value}} >{{$key}}</option>
                        @endif
                    @endforeach
                </select>

            </div>
            <input type="button" id="szerkesztes" value="Szerkesztés"></inputbutton>
            <button type="submit" id="mentes" style="display: none">Mentés</button>
        </div>
    </form>
    </div>
@else
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
@endif
</body>