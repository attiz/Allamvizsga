<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Tanárértékelő</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('/css/kerdoivStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            valaszok = [];
            $('#tovabb').click(function () {
                $('html, body').animate({scrollTop: 0}, 'fast');
                var index = $('#kerdes_id').val();
                var neptunkod = $('#neptunkod').val();
                var szak_id = $('#szak_id').val();
                var array = "{{ json_encode($kerdesek,JSON_UNESCAPED_UNICODE ) }}";
                var array2 = "{{ json_encode($tantargyak,JSON_UNESCAPED_UNICODE ) }}";
                var decoded = array.replace(/&quot;/g, '"');
                var decoded2 = array2.replace(/&quot;/g, '"');
                var kerdesek = JSON.parse(decoded);
                var tantargyak = JSON.parse(decoded2);
                if (index >= kerdesek.length - 1) {
                    document.getElementById("tovabb").style.display = "none";
                    document.getElementById("megjegyzes").style.display = "block";
                }
                document.getElementById("kerdes").innerHTML = kerdesek[index].kerdes;
                document.getElementById("valasz").innerHTML = kerdesek[index].valasz;
                index++;
                $('#kerdes_id').val(index);
                tantargyak.forEach(function (tantargy) {
                    var pont = $("input[name=valaszok" + tantargy.id + "[]]:checked").val();
                    if (pont == null) {
                        pont = 0;
                    }
                    var tanar = $('#' + tantargy.id + '').val();
                    var element = {};
                    element.utolso_kerdoiv = $('#utolso_kerdoiv').val();
                    element.kerdes_id = index - 1;
                    element.tantargy_id = tantargy.id;
                    element.tanar_id = tanar;
                    element.pont = pont;
                    element.neptunkod = neptunkod;
                    element.szak_id = szak_id;
                    valaszok.push(element);
                    $('input[name=valaszok' + tantargy.id + '[]]').attr('checked', false);
                    console.log(valaszok);
                });
            });
            $('#elkuld').click(function () {
                $('html, body').animate({scrollTop: 0}, 'fast');
                document.getElementById("veglegesit").style.display = "block";
                $('body').addClass('stop-scrolling');
            });
            $('#ment').click(function () {
                document.getElementById('veglegesit').style.display = 'none';
                $('body').removeClass('stop-scrolling');
                var jsonString = JSON.stringify(valaszok);
                var megjegyzes = $('#megjegyzesArea').val();
                var element = {};
                element.vegleges = 0;
                element.megjegyzes = megjegyzes;
                valaszok.push(element);
                console.log(jsonString);
                console.log(valaszok);
                $.ajax({
                    type: "POST",
                    url: "kerdoivElkuldes",
                    data: {valaszok: valaszok},
                    dataType: "json",
                    success: function (msg) {
                        //window.alert(JSON.stringify(msg));
                    }
                });
                window.location.replace('mentve');
            });
            $('#veg').click(function () {
                document.getElementById('veglegesit').style.display = 'none';
                $('body').removeClass('stop-scrolling');
                var jsonString = JSON.stringify(valaszok);
                var megjegyzes = $('#megjegyzesArea').val();
                var element = {};
                element.vegleges = 1;
                element.megjegyzes = megjegyzes;
                valaszok.push(element);
                console.log(jsonString);
                console.log(valaszok);
                $.ajax({
                    type: "POST",
                    url: "kerdoivElkuldes",
                    data: {valaszok: valaszok},
                    dataType: "json",
                    success: function (msg) {
                        // window.alert(JSON.stringify(msg));
                    }
                });
                window.location.replace('kitoltve');

            });

        });
    </script>
</head>

<body>
<div id="container">
    <div id="veglegesit">
        <form>
            <p class="popupTitle">Biztos benne?</p>
            <div class="popupButtonContainer">
                <button type="button" id="ment">Mentés</button>
                <button type="button" id="veg">Véglegesítés</button>
            </div>
        </form>
    </div>
    <div id="surveyContainer">
        <input type="hidden" id="kerdes_id" value=1>
        <input type="hidden" id="utolso_kerdoiv" value={{$kerdoiv_id}}>
        <input type="hidden" id="szak_id" value={{$tantargyak[0]->szak_id}}>
        <input type="hidden" id="neptunkod" value={{$_SESSION['neptunkod']}}>
        <div class="kerdes" name="kerdes" id="kerdes">{{$kerdesek[0]->kerdes}}</div>
        <div class="valasz" id="valasz">{{$kerdesek[0]->valasz}}</div>
        <div class="optionsContainer">
            @foreach($tantargyak as $index =>$tantargy)
                <div class="answers">
                    <p class="tantargy">{{$tanarok[$index]->nev}} - {{$tantargy->nev}}</p>
                    <div class="radioContainer">
                        <input type="hidden" id={{$tantargy->id}} value={{$tanarok[$index]->tanar_id}}>
                        @for($i=1;$i<=5;$i++)
                            <div class="radioWrap">
                                <input type="radio"
                                       value={{$i}} name={{'valaszok' . $tantargy->id . '[]'}} id={{'valaszok' . $tantargy->id . '[]'}}>
                                <label>{{$i}}</label>
                            </div>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>

        <div style="padding-left: 150px; padding-bottom: 50px; display: none" id="megjegyzes">
    <textarea id="megjegyzesArea"
              style="width: 90%;height: 100px;color: black; padding: 0 5px; spellcheck :'false'; resize: none;"
              placeholder="Írd be a megjegyzésed"></textarea>
        </div>
    </div>
    <div id="buttons">
        <input type="submit" name="action" value="Tovább" class="button" id="tovabb"/>
        <input type="submit" name="action" value="Elküld" class="button" id="elkuld"/>
    </div>
    <div style="padding: 40px">
    </div>
</div>
</body>
</html>