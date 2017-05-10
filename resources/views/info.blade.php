<!DOCTYPE html>
<html lang="hu">
<head>
    <link href="{{ asset('/css/kerdoivStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="container">
    <div id="kitoltve">
        <div class="kerdes">Üdvözöljük,<b>{{$_SESSION['neptunkod']}}</b>! Ezzel a neptunkóddal már volt kitöltve
            kérdőív!
        </div>
        <div class="kij">
            <form action="logoutDiak" method="get">
                <button id="logoutButton">Kijelentkezés</button>
            </form>
        </div>
    </div>
</div>
</body>