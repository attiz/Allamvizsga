<html>
<head>
    @if(session_status() == PHP_SESSION_NONE)
        {{session_start()}}
    @endif
</head>
<body>
    <h3>Kérdőív</h3>
    <p>Kérlek töltsd ki a kérdőívet!</p>
    {{Form::open(array('url' => 'kerdoivKitoltes'))}}
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
                    <td id ={{$tantargy->id}}>{{$tanarok[$index] . ' / ' . $tantargy->tantargy}}</td>
                    {{ Form::hidden('tantargyak[]',$tantargy->id)}}
                    <td>
                        @for($i=5; $i>0;$i--)
                            {{Form::radio('valaszok' . $kerdes->id . $tantargy->id . '[]',$i,
                            @\App\Http\Controllers\KerdoivController::isChecked($_SESSION['neptunkod'],$tantargy->id,$kerdes->id) ? 'checked' : null ,
                           null)}}
                            {{$i}}
                    @endfor
                    </td>
                </tr>
            @endforeach
        @endforeach
        <p></p>
    </table>
    <h4>Megjegyzés:</h4>
    {{Form::textarea('megjegyzes',  null, ['size' => '80x5'])}}
    <br>
    <input type="submit" name="mentes" value="Mentés">
    <input type="submit" name="elkuldes" value="Elküld">
    {{Form::close()}}

</body>
<style>
    td {
        width: 600px;
    }
</style>
</html>

