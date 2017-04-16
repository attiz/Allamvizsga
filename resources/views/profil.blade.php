<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Tanárok frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="tanarAdatok">
    <div class="labelDiv">
        <label>Név</label>
        <input type="text" id="nev" contenteditable="true"/>
    </div>
    <div class="labelDiv">
        <label>Tanszék</label>
        <input type="text" id="tanszek" contenteditable="true"/>
    </div>
    <div class="labelDiv">
        <label>Funkció</label>
        <input type="text" id="funkcio" contenteditable="true"/>
    </div>
    <div class="labelDiv">
        <label>Email</label>
        <input type="text" id="email" contenteditable="true"/>
    </div>
    <button type="submit" id="hozzaad">Hozzáad</button>
</div>
</body>