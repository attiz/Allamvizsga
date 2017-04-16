<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Tanár felület</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="container">
    <div id='cssmenu'>
        <ul>
            <li style="padding-left: 30px"><a href="profil" target="container2">Profil megtekintése</a></li>
            <li><a href="statisztikaEgyeni" target="container2">Statisztika</a></li>
            <li style="padding-right: 30px; float: right"><a class="active">Üdvözöljük, <b>{{$_SESSION['tanar']}}</b>!</a></li>
        </ul>
    </div>
</div>
<iframe id="container2" name="container2" src="profil" width="100%" height="750px"  frameborder="0">
</iframe>

</body>