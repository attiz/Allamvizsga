<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Órarend frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="table">
    <div id="top">
        <h2>Új óra hozzáadása</h2>
    </div>
</div>

<div id="tanarAdatok">
    <div class="labelDiv">
        <label>Szak</label>
        <input type="text" id="nev" contenteditable="true"/>
    </div>
    <div class="labelDiv">
        <label>Tantárgy</label>
        <input type="text" id="tanszek" contenteditable="true"/>
    </div>
    <div class="labelDiv">
        <label>Tanár</label>
        <input type="text" id="funkcio" contenteditable="true"/>
    </div>
    <button type="submit" id="hozzaad">Hozzáad</button>
</div>
</body>