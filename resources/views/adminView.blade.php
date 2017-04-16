<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Admin felulet</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="container">
    <div id='cssmenu'>
        <ul>
            <li style="padding-left: 30px"><a href="importExportTanar" target="container2">Tanárok kezelése</a></li>
            <li><a href="importExportDiakok" target="container2">Diákok kezelése</a></li>
            <li><a href="updateKerdes" target="container2">Kérdések kezelése</a></li>
            <li><a href="updateOrarend" target="container2">Órarend kezelése</a></li>
            <li><a href="statisztikaEgyeni" target="container2">Statisztika</a></li>
            <li style="padding-right: 30px; float: right"><a class="active">Üdvözöljük, <b>{{$_SESSION['tanar']}}</b>!</a></li>
        </ul>
    </div>
</div>
<iframe id="container2" name="container2" src="importExportTanar" width="100%" height="750px"  frameborder="0">
</iframe>

</body>