<html lang="en">
<head></head>

<body>
<h3>Orarend feldolgozasa</h3>
<h4>Tantárgyak feltöltése</h4>
@if ($message1 = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

@if ($message1 = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
@endif

<form action="{{ URL::to('feltoltTantargy') }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="file" name="import_tantargy" />
    {{ csrf_field() }}
    <br/>
    <button>Import Excel File</button>
</form>
<br/>


<h4>Osztályok feltöltése</h4>
@if ($message2 = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

@if ($message2 = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
@endif

<form action="{{ URL::to('feltoltOsztaly') }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="file" name="import_osztaly" />
    {{ csrf_field() }}
    <br/>
    <button>Import Excel File</button>
</form>
<br/>


<h4>Órák feldolgozása</h4>
@if ($message2 = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

@if ($message2 = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
@endif

<form action="{{ URL::to('feltoltOrak') }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="file" name="import_orak" />
    {{ csrf_field() }}
    <br/>
    <button>Import Excel File</button>
</form>
<br/>
</body>

</html>