<html lang="en">
<head>
    <title>Tanárok frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#importDiak').click(function () {
                document.getElementById("popup").style.display = "block";
                $('body').addClass('stop-scrolling');
            });
            $('#megse').click(function () {
                document.getElementById('popup').style.display = 'none';
                $('body').removeClass('stop-scrolling');
            });
        });
    </script>
</head>
<body>
<div id="table">
    <div id="top">
        <h2>Új tanszék hozzáadása</h2>
        @if ($message = Session::get('siker'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('siker') }}
            </div>
        @endif
        @if ($message = Session::get('hiba'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('hiba') }}
            </div>
        @endif
    </div>
</div>
<div id="tanarAdatok">
    <form action="{{ URL::to('hozzaadTanszek') }}" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="labelDiv">
            <label>Tanszék</label>
            <input type="text" id="tanszek" contenteditable="true" name="tanszek"/>
        </div>
        <button type="submit" id="hozzaad">Hozzáad</button>
    </form>
</div>
</body>

</html>