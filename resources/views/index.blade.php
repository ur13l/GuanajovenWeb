<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{url('materialize/css/materialize.min.css')}}">
    <link rel="stylesheet" href="{{url('css/style.css')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="{{url('js/jquery-1.12.3.js')}}"></script>
    <script type="text/javascript" src="{{url('materialize/js/materialize.js')}}"></script>
</head>
<body class="valign-wrapper">
<div class="container">
    <div class="row">
        <div class="col l6 m9 s12 offset-l3 offset-m2">
            <div class="card">
                <div class="card-image ">
                    <img src="{{url('img/background.png')}}">
                    <span class="card-title">Inicio de sesión</span>
                    <span class="card-title"><img class="col s5" style="margin-left:-25px; margin-bottom: 50px;" src="{{url('img/logo_guanajoven.png')}}"></span>
                    @if(isset($errors))
                        @foreach($errors as $error)
                            <div class="col s12 red" style="height:30px; padding-top:5px;">
                                <span class="white-text">
                                    {{$error}}
                                </span>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="card-content">
                    <form method="POST" action="{{url('/usuarios/login')}}">
                        <div class="input-field col s12 ">
                            <label for="correo">Correo</label>
                            <input type="email" class="validate" id="correo"/><br>
                        </div>
                        <div class="input-field col s12">
                            <label for="password" class="validate">Contraseña</label>
                            <input type="password" id="password"/><br>
                        </div>
                        <div class="input-field col right s5">
                            <div class="row">
                                <input class="waves-effect waves-light rose-code btn" style="background: #BF3364;" type="submit" name="Iniciar Sesión" value="Iniciar Sesión"/>
                            </div>
                        </div>
                    </form>
                    <p> &nbsp</p><br><br>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
