<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tanár - diák felmérő</title>
    <link rel="stylesheet" href="css/loginCss.css">
    <script src="js/index.js"></script>
</head>

<body>
<div class="container">
    <div class="cont_centrar">
        <div class="cont_login">
            <div class="container_full">
                <div class="col_md_login">
                    <div class="cont_ba_opcitiy">
                        <h2>Hallgató</h2>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                                <br>
                            </div>
                        @endif
                        <button class="btn_login" onclick="cambiar_login()">Bejelentkezés</button>
                    </div>
                </div>
                <div class="col_md_sign_up">
                    <div class="cont_ba_opcitiy">
                        <h2>Tanár</h2>
                        @if ($message = Session::get('siker'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('siker') }}
                                <br>
                            </div>
                        @endif
                        <button class="btn_login" onclick="cambiar_sign_up()">Bejelentkezés</button>
                    </div>
                </div>
            </div>


            <div class="cont_back_info">
                <div class="cont_img_back_grey">
                    <img src="sapi.jpg" alt=""/>
                </div>
            </div>
            <div class="cont_forms">
                <div class="cont_img_back_">
                    <img src="sapi.jpg" alt=""/>
                </div>
                <form class="login-form" method="post" action="{{ URL::to('loginDiak') }}" accept-charset="UTF-8">
                    <div class="cont_form_login">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <a href="#" onclick="ocultar_login_sign_up()"></a>
                        <h2>Hallgató</h2>
                        <input type="text" name="neptun" placeholder="neptunkód"/>
                        <button class="btn_login" type="submit" onclick="cambiar_login()">Bejelentkezés</button>

                    </div>
                </form>
                <form class="login-form" action="{{ URL::to('loginTanar') }}" method="post">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="cont_form_sign_up">
                        <a href="#" onclick="ocultar_login_sign_up()"></a>
                        <h2>Tanár</h2>
                        <input type="text" name="username" placeholder="felhasználónév"/>
                        <input type="password" name="passw" placeholder="jelszó"/>
                        <button class="btn_login" type="submit" onclick="cambiar_sign_up()">Bejelentkezés</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
