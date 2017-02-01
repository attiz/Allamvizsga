<html lang="en">
<head></head>

<body>
    <h3>Add student:</h3>
    <div>
        <form action="{{ URL::to('addDiak') }}" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <label>Neptun kód: </label>
            <input type="text" class="form-control" name="neptunkod">
            <label>Szak ID: </label>
            <input type="text" class="form-control" name="szak_id">
            <input type="submit" class="btn btn-primary" value="Add">
        </form>
    </div>

    <h3>Import Students from Excel file</h3>
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

    <form action="{{ URL::to('importDiak') }}" method="post" enctype="multipart/form-data">
        <input type="file" name="import_file" />
        {{ csrf_field() }}
        <br/>
        <button>Import Excel File</button>
    </form>
    <br/>

    <h3>Export Students from database</h3>
    <div>
        <a href="{{ url('exportDiak') }}"><button>Export</button></a>
    </div>


</body>

</html>