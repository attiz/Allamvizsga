<html lang="en">
<head>
    <title>Tanárok frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="diakok">
    <form id="importDiakok" action="importDiak" method="post">
        {{--<div>--}}
        {{--<form action="{{ URL::to('addDiak') }}" method="post">--}}
        {{--<input type="hidden" name="_token" value="{!! csrf_token() !!}">--}}
        {{--<span>Neptun kód: </span>--}}
        {{--<input type="text" class="form-control" name="neptunkod">--}}
        {{--<label>Szak ID: </label>--}}
        {{--<input type="text" class="form-control" name="szak_id">--}}
        {{--<input type="submit" class="btn btn-primary" value="Add">--}}
        {{--</form>--}}
        {{--</div>--}}


        {{--@if ($message = Session::get('success'))--}}
        {{--<div class="alert alert-success" role="alert">--}}
        {{--{{ Session::get('success') }}--}}
        {{--</div>--}}
        {{--@endif--}}

        {{--@if ($message = Session::get('error'))--}}
        {{--<div class="alert alert-danger" role="alert">--}}
        {{--{{ Session::get('error') }}--}}
        {{--</div>--}}
        {{--@endif--}}
        {{--<div class="buttons">--}}

        {{--<div class="buttons">--}}
        {{--<table>--}}
        {{--<tr>--}}
        {{--<td>--}}
        {{--<form id="importDiak" action="{{ URL::to('importDiak') }}" method="post"--}}
        {{--enctype="multipart/form-data">--}}
        {{--<input type="file" name="import_file"/>--}}
        {{--{{ csrf_field() }}--}}
        {{--</form>--}}
        {{--</td>--}}

        {{--<td>--}}

        {{--<a href="{{ url('exportDiak') }}">--}}
        {{--<button>Export</button>--}}
        {{--</a>--}}
        {{--</td>--}}
        {{--</tr>--}}
        {{--</table>--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="buttons">
            <table>
                <tr>
                    <td>
                        <div class="selector">
                            <div id="uploadTantargy">
                                <button id="1" type="button" >Importálás</button>
                                {{ csrf_field() }}
                                <span id="tanarSpan">Diákok feltöltése</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="selector">
                            <div id="uploadOrak">
                                <button id="1" type="button" >Exportálás</button>
                                <span id="tanarSpan">Diákok exportálása</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </form>

</div>
</body>

</html>