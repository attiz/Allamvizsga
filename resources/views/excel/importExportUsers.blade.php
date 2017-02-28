<html lang="en">
<head></head>

<body>
<h3>Import Users from Excel file</h3>
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

<form action="{{ URL::to('importTanar') }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="file" name="import_file" />
    {{ csrf_field() }}
    <br/>
    <button>Import Excel File</button>
</form>
<br/>

<h3>Export Users from database</h3>
<div>
    <a href="{{ url('exportTanar') }}"><button>Export</button></a>
</div>


</body>

</html>