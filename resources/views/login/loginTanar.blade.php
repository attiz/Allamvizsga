<!DOCTYPE html>
<html>
<head>
    <title>Tanár-diák felmérő</title>
    <link href="{{ asset('/css/loginStyle.css') }}" rel="stylesheet">
</head>
<body>
<div class="login-page">
    <div class="form">
        <form class="login-form" action="{{ URL::to('loginTanar') }}" method="post">
            <h2>Tanár</h2>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                    <br>
                </div>
            @endif
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="text" placeholder="felhasználó név" name="username"/>
            <input type="password" placeholder="jelszó" name="passw"/>
            <input type="submit" class="btn btn-primary" value="Bejelentkezés">
        </form>
    </div>
</div>
</body>
</html>