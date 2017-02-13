<html>
<head></head>
<body>
    <h3>Üdvözlünk</h3>
    <p>Kérlek válaszd ki az ebbe a félévbe tanult tantárgyaidat!</p>
    {{Form::open(array('url' => 'generateKerdoiv', 'method' => 'post'))}}
    @foreach ($tantargyak as $res)
        {{Form::checkbox('tantargyak[]',$res->id,null,null)}}
        {{$res->nev}}<br>
    @endforeach
    <p></p>
    <button class="btn btn-default">Választ</button>
    {{Form::close()}}

</body>
</html>