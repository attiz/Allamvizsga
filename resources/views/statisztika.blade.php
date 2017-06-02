<!DOCTYPE HTML>
<html>
<head>
    <title>Tanárértékelő</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
    <link href="{{ asset('/css/statisztikaStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="tableView">
    {{Form::open(array('url' => 'statisztikaElonezet','method' => 'POST'))}}
    <div id="div1">
        <div class="selector">
            <span>Tanár</span>
            <select name="tanarok">
                <option value = 0>Összes tanár</option>
                @foreach($tanarok as $tanar)
                    <option value={{$tanar->id}}>{{$tanar->nev}}</option>
                @endforeach
            </select>

        </div>
        <div class="selector">
            <span>Szak</span>
            <select name="szakok">
                <option value = 0>Összes szak</option>
                @foreach($szakok as $szak)
                    <option value={{$szak->id}}>{{$szak->szaknev}}</option>
                @endforeach
            </select>
        </div>
        <div class="selector">
            <span>Tantárgy</span>
            <select name="tantargyak">
                <option>Összes</option>
                <option>Osztott rendszerek</option>
                <option>Osztott rendszerek - EA</option>
                <option>Osztott rendszerek - GY</option>
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
            <button type="submit">Mehet</button>
            <button type="button">Exportálás</button>
        </div>
    </div>
    @if (isset($valaszok))
        <section id="statTable">

            <div class="classContainer">
                <div class="kerdesek">
                    <div class="fejlec"><span class="qInfoLeft">Kérdés</span><span
                                class="qInfoRight">Átlag</span>
                    </div>
                    @foreach($valaszok as $valasz)
                        <div class="question"><span class="ker">{{$valasz->kerdes}}</span>
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
{{--<body>--}}
{{--@if (isset($tanarok))--}}
{{--<h3>Statisztika</h3>--}}
{{--{{Form::open(array('url' => 'statisztikaElonezet','method' => 'POST'))}}--}}
{{--<select name="tanarok">--}}
{{--@foreach($tanarok as $tanar)--}}
{{--<option value={{$tanar->id}}>{{$tanar->nev}}</option>--}}
{{--@endforeach--}}
{{--</select>--}}
{{--<select name="szakok">--}}
{{--@foreach($szakok as $szak)--}}
{{--<option value={{$szak->id}}>{{$szak->szaknev}}</option>--}}
{{--@endforeach--}}
{{--</select>--}}
{{--{{Form::checkbox('email',1,null,null)}}--}}
{{--Küldje ki e-mailbe--}}
{{--<input type="submit" name="action" value="Mehet" />--}}
{{--{{Form::close()}}--}}
{{--@endif--}}
{{--@if (isset($valaszok))--}}
{{--<h3>{{$tanar}}</h3>--}}
{{--<table border="1" class="table">--}}
{{--<tr>--}}
{{--@foreach($valaszok as $valasz)--}}
{{--<th align="center" id={{$valasz->id}}>{{$valasz->id . '. ' . $valasz->kerdes}}</th>--}}

{{--@endforeach--}}
{{--<td>--}}
{{--<th>Átlag</th>--}}
{{--</td>--}}
{{--<td>--}}
{{--<th>Szám</th>--}}
{{--</td>--}}
{{--</tr>--}}
{{--<tr>--}}
{{--@foreach($valaszok as $valasz)--}}
{{--<td align="center">{{$valasz->atlag}}</td>--}}
{{--@endforeach--}}
{{--<td>--}}
{{--<th>{{$atlag}}</th>--}}
{{--</td>--}}
{{--<td>--}}
{{--<th>{{$hanyan}}</th>--}}
{{--</td>--}}
{{--</tr>--}}
{{--</table>--}}
{{--{{Form::open(array('url' => 'statisztikaExport','method' => 'POST'))}}--}}
{{--<input type="submit" name="action" value="Export" />--}}
{{--{{ Form::hidden('tanar',$tid)}}--}}
{{--{{ Form::hidden('szak',$szid)}}--}}
{{--{{Form::close()}}--}}
{{--@endif--}}
{{--</body>--}}
</html>