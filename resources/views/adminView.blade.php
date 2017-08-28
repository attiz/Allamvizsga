<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Admin felulet</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#jelszo').click(function () {
                document.getElementById("popupJelszo").style.display = "block";
                $('body').addClass('stop-scrolling');
                document.getElementById('regi').value = "";
                document.getElementById('uj').value = "";
                document.getElementById('uj2').value = "";
            });
            $('#megse').click(function () {
                document.getElementById('popupJelszo').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
            $('#jelszoCsere').click(function () {
                document.getElementById('popupJelszo').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
        });
    </script>
</head>
<body>
<div id="container">
    <div id="popupJelszo">
        <form action="jelszoCsere" target="container2" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <p class="popupTitle">Jelszó módosítás</p>
            <div class="popupButtonContainer">
                <label>Régi jelszó</label><input type="password" name="regi" id="regi" required>
                <label>Új jelszó</label><input type="password" name="uj" id="uj" required>
                <label>Új jelszó még egyszer</label><input type="password" name="uj2" id="uj2" required>
                <button type="submit" id="jelszoCsere">Mentés</button>
                <button type="button" id="megse">Mégse</button>
            </div>
        </form>
    </div>
    <div id='cssmenu'>
        <ul>
            <li style="padding-left: 30px"><a href="importExportTanar" target="container2">Tanárok kezelése</a></li>
            <li><a href="importExportDiakok" target="container2">Diákok kezelése</a></li>
            <li><a href="updateKerdes" target="container2">Kérdések kezelése</a></li>
            <li><a href="updateOrarend" target="container2">Tantárgyak kezelése</a></li>
            <li><a href="updateTanszek" target="container2">Tanszékek kezelése</a></li>
            <li><a href="statisztikaEgyeni" target="container2">Statisztika</a></li>
            <li class="dropdown" style="padding-right: 30px; float: right">
                <a href="javascript:void(0)" class="dropbtn">Üdvözöljük,<b>{{$_SESSION['tanar']}}</b>!</a>
                <div class="dropdown-content">
                    <a href="profil" target="container2">Profil megtekintése</a>
                    <a href="#" id="jelszo">Jelszó módosítás</a>
                    <a href="logoutTanar">Kijelentkezés</a>
                </div>
            </li>
        </ul>
    </div>
</div>
<iframe id="container2" name="container2" src="importExportTanar" width="100%" height="750px" frameborder="0">
</iframe>

</body>