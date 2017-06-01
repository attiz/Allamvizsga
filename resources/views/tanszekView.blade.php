<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kérdések frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script>
        $(document).ready(function () {
            var kerdes_id;
            $('#importKerdes').click(function () {
                document.getElementById("popup").style.display = "block";
                $('body').addClass('stop-scrolling');
            });
            $('#megse').click(function () {
                document.getElementById('popup').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
            $('.torolTanar').click(function () {
                tanszek_id = $(this).val();
                $('#tanszID').val(tanszek_id);
                $('html, body').animate({scrollTop: 0}, 'fast');
                document.getElementById('popupTorol').style.display = 'block';
                $('body').addClass('stop-scrolling');
            });
            $('#nem').click(function () {
                document.getElementById('popupTorol').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
        });
    </script>
</head>
<body>
<div id="kerdesek">
    <div id="popupTorol">
        <div id="torles">
            <p class="popupTitle">Biztosan törli?</p>
            <div class="popupButtonContainer">
                <form action="torolTanszek" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="tanszID" id="tanszID" value="0">
                    <button id="igen">Törlés</button>
                    <button id="nem" type="button">Mégse</button>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="classContainer">
    <div class="kerdesek">
        <div class="fejlec">
            <span class="fejlecBal">Tanszék</span>
        </div>
        @foreach($tanszekek as $tanszek)
            <div class="kerdesDiv">
                <button class="torolTanar" style="float: right;" value={{$tanszek->id}}><span>Töröl</span>
                </button>
                <form action="modositTanszek" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <span class="tanGomb">
                    <div class="modositGombok">
                        <input type="hidden" name="tanszek_id" value={{ $tanszek->id }}>
                        <button id="modositTanar"><span>Módosít</span></button>
                         </div>
                    </span>
                </form>
                <span class="kerdesSpan"><b>{{$tanszek->nev}}</b></span>

            </div>
        @endforeach
        <div class="fejlec">
            <span class="ujTanGomb"><a href="hozzaadTanszek" target="container2"
                                       id="hozzaadas">Új tanszék hozzáadása</a></span>
        </div>

    </div>
</div>

</body>