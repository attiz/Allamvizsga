<!DOCTYPE HTML>
<html>
<head>
    <title>Tanárértékelő</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/statisztikaStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#tanarok").change(function () {
                var tanarID = $(this).val();
                select = document.getElementById('szakok');
                document.getElementById("szakok").options.length = 1;
                document.getElementById("tantargyak").options.length = 1;
                $.ajax({
                    type: "POST",
                    url: 'getSzakok',
                    data: 'tanar_id=' + tanarID,
                    success: function (szakok) {
                        $('#tanarID').val(tanarID);
                        var obj = szakok.szakok;
                        var array = Object.values(obj);
                        array.forEach(function (tant) {
                            var opt = document.createElement('option');
                            opt.value = tant.id;
                            opt.innerHTML = tant.nev;
                            select.appendChild(opt);
                        });
                    }
                });
            });
            $("#szakok").change(function () {
                var tanar_id = $('#tanarID').val();
                var szakID = $(this).val();
                var element = {};
                element.tanar_id = tanar_id;
                element.szak_id = szakID;
                select = document.getElementById('tantargyak');
                document.getElementById("tantargyak").options.length = 1;
                $.ajax({
                    type: "POST",
                    url: 'getTantargyak',
                    data: {element: element},
                    success: function (tantargyak) {
                        var obj = tantargyak.tantargyak;
                        var array = Object.values(obj);
                        array.forEach(function (tant) {
                            var opt = document.createElement('option');
                            opt.value = tant.id;
                            opt.innerHTML = tant.nev;
                            select.appendChild(opt);
                        });
                    }
                });
            });
        });
    </script>
</head>
<body>
<div id="tableView">
    {{Form::open(array('url' => 'statisztikaEgyeni','method' => 'POST'))}}
    <div id="div1">
        <div class="selector">
            <span>Tanár</span>
            <input type="hidden" name="tanarID" id="tanarID" value={{$_SESSION['tanar_id']}}>
            <select name="tanarok" id="tanarok">
                @if (isset($tid))
                    @foreach($tanarok as $tanar)
                        @if ($tanar->id == $tid)
                            <option value={{$tanar->id}} selected>{{$tanar->nev}}</option>
                        @else
                            <option value={{$tanar->id}} >{{$tanar->nev}}</option>
                        @endif
                    @endforeach
                @else
                    @foreach($tanarok as $tanar)
                        @if ($tanar->id == $_SESSION['tanar_id'])
                            <option value={{$tanar->id}} selected>{{$tanar->nev}}</option>
                        @else
                            <option value={{$tanar->id}} >{{$tanar->nev}}</option>
                        @endif
                    @endforeach
                @endif
            </select>

        </div>
        <div class="selector">
            <span>Szak</span>
            <select name="szakok" id="szakok">
                @if(isset($szakok))
                    <option value=0>Összes szak</option>
                    @foreach($szakok as $sz)
                        <option value="{{$sz->id}}">{{$sz->szaknev}}</option>
                    @endforeach
                @else
                    @if(isset($szak[0]))
                        <option value=0>Összes szak</option>
                        <option value="{{@$szak[0]->id}}" selected>{{@$szak[0]->szaknev}}</option>
                    @else
                        <option value=0>Összes szak</option>
                    @endif
                @endif
            </select>
        </div>
        <div class="selector">
            <span>Tantárgy</span>
            <select name="tantargyak" id="tantargyak">
                @if(isset($tantargy[0]))
                    <option value=0>Összes tantárgy</option>
                    <option value="{{@$tantargy[0]->id}}" selected>{{@$tantargy[0]->nev}}</option>
                @else
                    <option value=0>Összes tantárgy</option>
                @endif
            </select>
        </div>
        <div class="selector">
            <span>Mettől</span>
            <select name="mettol">
                <option>2016/17/2</option>
                <option>2016/17/1</option>
                <option>2015/16/2</option>
                <option>2015/16/1</option>
            </select>
        </div>
        <div class="selector">
            <span>Meddig</span>
            <select name="meddig">
                <option>2016/17/2</option>
                <option>2016/17/1</option>
                <option>2015/16/2</option>
                <option>2015/16/1</option>
            </select>
        </div>
    </div>
    <div id="div2">
        <div class="buttons">
            <button type="submit" name="action" value="mehet">Mehet</button>
            <button type="submit" name="action" value="export">Exportálás</button>
            <input type="checkbox" name="kikuldes" id="kikuldes">
            <label id="kikuldesLabel">kiküldés e-mailbe</label>
        </div>
    </div>
    @if(isset($nincs))
        <div id="container">
            <div id="kitoltve">
                <div class="kerdes">Nincs megjeleníthető eredmény!
                </div>
            </div>
        </div>
    @endif
    @if (isset($valaszok))
        <section id="statTable">

            <div class="classContainer">
                <div class="kerdesek">
                    <div class="fejlec"><span class="qInfoLeft">Kérdés</span><span
                                class="qInfoRight">Átlag</span>
                    </div>
                    @foreach($valaszok as $valasz)
                        <div class="question"><span class="ker">{{$valasz->kerdes}}</span>
                            {{--<br><span class="val">{{$valasz->valasz1}},{{$valasz->valasz2}},{{$valasz->valasz3}},{{$valasz->valasz4}},{{$valasz->valasz5}}</span>--}}
                            <span class="atlag">{{$valasz->atlag}}</span>
                        </div>
                    @endforeach
                    <div class="osszesites"><span class="ossz">Összesített átlag</span><span
                                class="osszAtlag">{{$atlag}}</span>
                    </div>
                    <div class="osszesites"><span class="ossz">Kitöltések száma</span><span
                                class="osszAtlag">{{$hanyan}}</span>
                    </div>
                </div>

            </div>
        </section>
        {{Form::close()}}
    @endif
</div>

</body>
</html>