<!DOCTYPE HTML>
<html>
<head>
    <script type="text/javascript">
        $(document).ready(function (e) {
            $("#ment").click(function (e) {
                $(".table").table2excel({
                    name : "osszesites",
                    filename: "osszesites",
                    fileext: ".xls"
                })
            })
        })
    </script>
</head>
<body>
    @if (isset($tanarok))
        <h3>Statisztika</h3>
        {{Form::open(array('url' => 'statisztikaElonezet','method' => 'POST'))}}
        <select name="tanarok">
            @foreach($tanarok as $tanar)
                <option value={{$tanar->id}}>{{$tanar->nev}}</option>
            @endforeach
        </select>
        <select name="szakok">
            @foreach($szakok as $szak)
                <option value={{$szak->id}}>{{$szak->szaknev}}</option>
            @endforeach
        </select>
        {{Form::checkbox('email',1,null,null)}}
        Küldje ki e-mailbe
        <input type="submit" name="action" value="Mehet" />
        {{Form::close()}}
    @endif
    @if (isset($valaszok))
        <h3>{{$tanar}}</h3>
        <table border="1" class="table">
                <tr>
                    @foreach($valaszok as $valasz)
                        <th align="center" id={{$valasz->id}}>{{$valasz->id . '. ' . $valasz->kerdes}}</th>

                    @endforeach
                        <td>
                            <th>Átlag</th>
                        </td>
                        <td>
                            <th>Szám</th>
                        </td>
                </tr>
                <tr>
                    @foreach($valaszok as $valasz)
                        <td align="center">{{$valasz->atlag}}</td>
                    @endforeach
                        <td>
                        <th>{{$atlag}}</th>
                        </td>
                        <td>
                        <th>{{$hanyan}}</th>
                        </td>
                </tr>
        </table>
        {{Form::open(array('url' => 'statisztikaExport','method' => 'POST'))}}
                <input type="submit" name="action" value="Export" />
                {{ Form::hidden('tanar',$tid)}}
                {{ Form::hidden('szak',$szid)}}
        {{Form::close()}}
    @endif
</body>
</html>