<html>
<head></head>
<body>
    <h3>Kérdőív</h3>
    <p>Kérlek töltsd ki a kérdőívet!</p>
    {{Form::open(array('url' => 'kerdoivKitoltes', 'method' => 'post'))}}
    @foreach ($kerdesek as $kerdes)
       {{$kerdes->id . '. ' . $kerdes->kerdes}}<br>
       @for ($i = 5; $i  >= 1; $i--)
        {{Form::checkbox('valaszok[]',$i,null,null)}}
           {{$i}}
       @endfor
        <br>
    @endforeach
    <p></p>
    <button class="btn btn-default">Elküld</button>
    {{Form::close()}}

</body>
</html>