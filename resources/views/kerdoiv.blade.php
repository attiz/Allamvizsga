<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Tanárértékelő</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/kerdoivStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tovabb').click(function () {
                var index = $('#kerdes_id').val();
                console.log('kerdes: ' + index);
                var neptunkod = $('#neptunkod').val();
                var szak_id = $('#szak_id').val();
                var array = "{{ json_encode($kerdesek,JSON_UNESCAPED_UNICODE ) }}";
                var array2 = "{{ json_encode($tantargyak,JSON_UNESCAPED_UNICODE ) }}";
                var decoded = array.replace(/&quot;/g, '"');
                var decoded2 = array2.replace(/&quot;/g, '"');
                var kerdesek = JSON.parse(decoded);
                var tantargyak = JSON.parse(decoded2);
                if (index > kerdesek.length - 1) {
                    document.getElementById("tovabb").style.display = "none";
                    document.getElementById("megjegyzes").style.display = "block";
                }
                document.getElementById("kerdes").innerHTML = kerdesek[index].kerdes;
                document.getElementById("valasz").innerHTML = kerdesek[index].valasz;
                index++;
                $('#kerdes_id').val(index);
                valaszok = [];
                tantargyak.forEach(function (tantargy) {
                    var pont = $("input[name=valaszok" + tantargy.id + "[]]:checked").val();
                    var tanar = $('#' + tantargy.id + '').val();
                    console.log('tantargy:' + tantargy.id);
                    console.log('tanar: ' + tanar);
                    console.log('valasz: ' + pont);
                    var element = {};
                    element.kerdes_id = index - 1;
                    element.tantargy_id = tantargy.id;
                    element.tanar_id = tanar;
                    element.pont = pont;
                    element.neptunkod = neptunkod;
                    element.szak_id = szak_id;
                    valaszok.push(element);
                    $('input[name=valaszok' + tantargy.id + '[]]').attr('checked', false);
                });
                console.log(valaszok);


            });
            $('#elkuld').click(function () {
                window.location.replace('kitoltve');
            });

        });
    </script>
</head>

<body>
<div id="container">
    <div id="surveyContainer">
        {{--{{Form::open(array('url' => 'kerdoivKitoltes','method'=>'post'))}}--}}
        {{ Form::hidden('utolso_kerdoiv',$utolso_kerdoiv)}}
        <input type="hidden" id="kerdes_id" value=1>
        <input type="hidden" id="neptunkod" value={{$_SESSION['neptunkod']}}>
        <input type="hidden" id="szak_id" value={{$_SESSION['szak']}}>
        <div class="kerdes" name="kerdes" id="kerdes">{{$kerdesek[0]->kerdes}}</div>
        <div class="valasz" id="valasz">{{$kerdesek[0]->valasz}}</div>
        <div class="optionsContainer">
            @foreach($tantargyak as $index =>$tantargy)
                <div class="answers">
                    <p class="tantargy">{{$tanarok[$index]->nev}} - {{$tantargy->tantargy}}</p>
                    <div class="radioContainer">
                        @for($i=1;$i<=5;$i++)
                            <div class="radioWrap">
                                <input type="radio"
                                       value={{$i}} name={{'valaszok' . $tantargy->id . '[]'}} id={{'valaszok' . $tantargy->id . '[]'}}>
                                <label>{{$i}}</label>
                                <input type="hidden" id={{$tantargy->id}} value={{$tanarok[$index]->tanar_id}}>
                            </div>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>

        <div style="padding-left: 150px; display: none" id="megjegyzes">
    <textarea id="megjegyzesArea" style="width: 90%;;height: 100px;color: transparent; padding: 0 5px; resize: none;"
              placeholder="Írd be a megjegyzésed"></textarea>
        </div>
    </div>
    <div id="buttons">
        <input type="submit" name="action" value="Tovább" class="button" id="tovabb"/>
        <input type="submit" name="action" value="Elküld" class="button" id="elkuld"/>
{{--       {{Form::close()}}--}}
    </div>
    <div style="padding: 40px">
    </div>
</div>
</body>
</html>