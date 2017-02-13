<html lang="en">
<head></head>

<body>
    <h3>Add question:</h3>
    <div>
        <form action="{{ URL::to('addKerdes') }}" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="text" class="form-control" name="question">
            <input type="submit" class="btn btn-primary" value="Add">
        </form>
    </div>

    <h3>Import Questions from Excel file</h3>
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

    <form action="{{ URL::to('importKerdesek') }}" method="post" enctype="multipart/form-data">
        <input type="file" name="import_file" />
        {{ csrf_field() }}
        <br/>
        <button>Import Excel File</button>
    </form>
    <br/>

    <h3>Export Questions from database</h3>
    <div>
        <a href="{{ url('exportKerdesek') }}"><button>Export</button></a>
    </div>


</body>

</html>