<html>
<head></head>
<body>
    <h3>Kérdőív</h3>
    <p>Kérlek töltsd ki a kérdőívet!</p>
    {{Form::open(array('url' => 'kerdoivKitoltes', 'method' => 'post'))}}
    {{ Form::hidden('utolso_kerdoiv',$utolso_kerdoiv)}}
    <table>
        @foreach ($kerdesek as $kerdes)
            <tr>
                <th colspan="2" align="left" id={{$kerdes->id}}>{{$kerdes->id . '. ' . $kerdes->kerdes}}</th>
            </tr>
            <tr>
                <td><i>{{$kerdes->valasz}}</i></td>
            </tr>
            @foreach($kivalasztott as $index =>$tantargy)
                <tr>
                    <td id ={{$tantargy->id}}>{{$tanarok[$index] . ' / ' . $tantargy->nev}}</td>
                    {{ Form::hidden('tantargyak[]',$tantargy->id)}}
                    <td>
                        @for ($i = 5; $i  >= 1; $i--)
                            {{Form::radio('valaszok' . $kerdes->id . $tantargy->id . '[]',$i,null,null)}}
                            {{$i}}
                        @endfor
                    </td>
                </tr>
            @endforeach
        @endforeach
        <p></p>
    </table>
    <button class="btn btn-default">Elküld</button>
    {{Form::close()}}

</body>
<style>
    td {
        width: 600px;
    }
</style>
</html>

