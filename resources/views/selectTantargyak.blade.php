<html>
<head></head>
<body>
    <h3>Üdvözlünk, <b>{{$_SESSION['neptunkod']}}</b> ! </h3>
        @if (isset($szakok))
            <p>Kérlek válaszd ki a csoportodat!</p>
            {{Form::open(array('url' => 'generateTantargyak', 'method' => 'post'))}}
            <select name="szakok">
                @foreach($szakok as $szak)
                    <option value={{$szak->id}}>{{$szak->szaknev}}</option>
                @endforeach
            </select>
            <button class="btn btn-default">Mehet</button>
            {{Form::close()}}
            <p></p>
        @endif
        @if (isset($tantargyak))
            <p>Kérlek válaszd ki a tantárgyaid!</p>
            {{Form::open(array('url' => 'generateKerdoiv', 'method' => 'post'))}}
            @foreach ($tantargyak as $res)
                {{Form::checkbox('tantargyak[]',$res->id,'yes',null)}}
                {{$res->nev}}<br>
            @endforeach
            <p></p>
            <button class="btn btn-default">Választ</button>
            {{Form::close()}}
        @endif

</body>
</html>