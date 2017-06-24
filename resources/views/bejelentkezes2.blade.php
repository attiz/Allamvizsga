<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tanár - diák felmérő</title>
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">


    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form">
    <ul class="tab-group">

        <li class="tab"><a href="#signup">Hallgató</a></li>
        <li class="tab active"><a href="#login">Tanár</a></li>
    </ul>
    <div class="tab-content">
        <div id="login">
            <h1>Tanár</h1>
            <div class="uzenet">
                @if ($message = Session::get('error'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('error') }}
                        <br>
                    </div>
                @endif
            </div>
            <form class="login-form" action="{{ URL::to('loginTanar') }}" method="post">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <div class="field-wrap">
                    <label>
                        felhasználónév<span class="req">*</span>
                    </label>
                    <input type="text" name="username" class="kitoltendo" required autocomplete="off"/>
                </div>

                <div class="field-wrap">
                    <label>
                        jelszó<span class="req">*</span>
                    </label>
                    <input type="password" name="passw" class="kitoltendo" required autocomplete="off"/>
                </div>

                <button class="button button-block"/>
                Bejelentkezés</button>

            </form>

        </div>
        <div id="signup">
            <h1>Hallgató</h1>
            <div class="uzenet">
                @if ($message = Session::get('hiba'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('hiba') }}
                        <br>
                    </div>
                @endif
            </div>
            <form class="login-form" method="post" action="{{ URL::to('bejelentkezesDiak') }}" accept-charset="UTF-8">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">


                <div class="field-wrap">
                    <label>
                        neptunkód<span class="req">*</span>
                    </label>
                    <input type="text" name="neptun" class="kitoltendo" required autocomplete="off"/>
                </div>


                <div class="field-wrap">
                </div>

                <button type="submit" class="button button-block"/>
                Bejelenkezés</button>

            </form>

        </div>


    </div><!-- tab-content -->

</div> <!-- /form -->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index2.js"></script>

</body>
</html>
