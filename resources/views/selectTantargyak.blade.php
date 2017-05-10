<html>
<head>
    <link href="{{ asset('/css/tantargyStyle.css') }}" rel="stylesheet">
</head>
<body>
@if (isset($szakok))
    <div id="kivalasztSzak">
        <h3>Üdvözlünk, <b>{{$_SESSION['neptunkod']}}</b> ! </h3>
        <p class="p1">Kérlek válaszd ki a csoportodat!</p>
        {{Form::open(array('url' => 'generateTantargyak', 'method' => 'post'))}}
        <select class="szakok" name="szakok">
            @foreach($szakok as $szak)
                <option value={{$szak->id}}>{{$szak->szaknev}}</option>
            @endforeach
        </select>
        <button class="kivalasztSzak">Mehet</button>
        {{Form::close()}}
        @endif
    </div>
    @if (isset($tantargyak))
        <div id="kivalasztTantargyak">
            <p class="p1">Kérlek válaszd ki a tantárgyaid!</p>
            {{Form::open(array('url' => 'generateKerdoiv', 'method' => 'post'))}}
            @foreach ($tantargyak as $res)
                <input type="checkbox" name="tantargyak[]" class="tantargyak" value={{$res->tantargy_id}}|{{$res->tanar_id}}>
                <label class="l1">{{$res->nev}} - {{$res->tanar}} </label><br>
            @endforeach
            <p></p>
            <button class="kivalasztTantargy">Választ</button>
            {{Form::close()}}
            @endif
        </div>
    <div style="padding: 30px;"></div>

</body>
</html>