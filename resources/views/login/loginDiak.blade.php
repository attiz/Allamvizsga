<!DOCTYPE html>
<html>
<head>
    <title>Tanár-diák felmérő</title>
    <link href="{{ asset('/css/loginStyle.css') }}" rel="stylesheet">
</head>
<body>
<div class="login-page">
    <div class="form">
        <h2>Diák</h2>
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
                <br>
            </div>
        @endif
        <form class="login-form" method="post" action="{{ URL::to('loginDiak') }}" accept-charset="UTF-8">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="text" placeholder="neptun kód" name="neptun"/>
            <input type="submit" class="btn btn-primary" value="Bejelentkezés">
        </form>
    </div>
</div>
</body>
</html>

