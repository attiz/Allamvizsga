var script = document.createElement('script');
script.src = 'http://code.jquery.com/jquery-1.4.3.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);
$(document).ready(function () {
    valaszok = [];
    var array = "{{ json_encode($kerdesek,JSON_UNESCAPED_UNICODE ) }}";
    var array2 = "{{ json_encode($tantargyak,JSON_UNESCAPED_UNICODE ) }}";
    var decoded = array.replace(/&quot;/g, '"');
    var decoded2 = array2.replace(/&quot;/g, '"');
    var kerdesek = JSON.parse(decoded);
    var tantargyak = JSON.parse(decoded2);
    var index = $('#kerdes_id').val();

    $('#tovabb').click(function () {
        $('html, body').animate({scrollTop: 0}, 'fast');
        var neptunkod = $('#neptunkod').val();
        var szak_id = $('#szak_id').val();

        if (index >= kerdesek.length - 2) {
            document.getElementById("tovabb").style.display = "none";
            document.getElementById("megjegyzes").style.display = "block";
        }
        index++;
        if (index == 1) {
            document.getElementById("vissza").style.display = "block";
        }
        document.getElementById("kerdes").innerHTML = kerdesek[index].kerdes;
        document.getElementById("valasz").innerHTML = kerdesek[index].valasz1 + ',' + kerdesek[index].valasz2 + ',' + kerdesek[index].valasz3 + ',' + kerdesek[index].valasz4 + ',' + kerdesek[index].valasz5;


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
        });
    });
    $('#vissza').click(function () {
        index--;

        document.getElementById("kerdes").innerHTML = kerdesek[index].kerdes;
        document.getElementById("valasz").innerHTML = kerdesek[index].valasz1 + ',' + kerdesek[index].valasz2 + ',' + kerdesek[index].valasz3 + ',' + kerdesek[index].valasz4 + ',' + kerdesek[index].valasz5;
        if (index <= 0) {
            document.getElementById("vissza").style.display = "none";
        }
        if (index >= kerdesek.length - 2) {
            document.getElementById("megjegyzes").style.display = "none";
            document.getElementById("tovabb").style.display = "block";
        }
        valaszok.forEach(function (val) {
            if (index == val.kerdes_id) {
                var radios = document.getElementsByName('valaszok' + val.tantargy_id + '[]');
                for (i = 0; i < radios.length; i++) {
                    if (radios[i].value == val.pont) {
                        radios[i].checked = true;
                    }
                }
            }
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

