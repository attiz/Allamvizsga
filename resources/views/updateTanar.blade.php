<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Tanárok frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script>
        $(function () {
            var availableTags = [
                "ActionScript",
                "AppleScript",
                "Asp",
                "BASIC",
                "C",
                "C++",
                "Clojure",
                "COBOL",
                "ColdFusion",
                "Erlang",
                "Fortran",
                "Groovy",
                "Haskell",
                "Java",
                "JavaScript",
                "Lisp",
                "Perl",
                "PHP",
                "Python",
                "Ruby",
                "Scala",
                "Scheme"
            ];
            $("#inputText").autocomplete({
                source: availableTags
            });
        });
    </script>


</head>
<body>
<div id="tanarView">
    <form id="tanarUpdate">
        <div class="buttons">
            <table>
                <tr>
                    <td>
                        <div class="selector">
                            <input id="inputText" class="textbox" type="text" placeholder="Tanár neve">
                            <button type="submit" id="tanarSzures">Szűrés</button>
                        </div>
                    </td>
                    <td>
                        <div class="selector">
                            <div id="uploadTanar">
                                <button id=frissites type="button">Importálás</button>
                                <span id="tanarSpan">Tanárok adatainak frissítése</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
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
    <button type="submit" id="mentes">Mentés</button>
</div>
</body>