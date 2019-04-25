<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION ['authenticated'])) {
    if ($_SESSION ['authenticated'] == 1) {
        header("Location: index.php");
    }
}
?>
<html lang="en">

    <head>
        <title>SISTEMA DE ADMINISTRACIÓN EMPRESARIAL</title>
        <!-- Meta tag Keywords -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <!-- Meta tag Keywords -->
        <!-- css files -->
        <link href="https://fonts.googleapis.com/css?family=Allan" rel="stylesheet">
        <link type="text/css" rel="stylesheet"
              href="dist/css/pages/cronometro.css">
        <!-- Style-CSS -->
        <link rel="stylesheet" href="dist/css/font-awesome.css">
        <!-- Font-Awesome-Icons-CSS -->
        <link
            href="//fonts.googleapis.com/css?family=Muli:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext,vietnamese"
            rel="stylesheet">
        <!-- Favicon -->
        <link rel="shortcut icon" href="dist/img/favicon.ico">

        <!-- Alertify -->
        <link rel="stylesheet" href="plugins/alertify/alertify.default.css">
        <link rel="stylesheet" href="plugins/alertify/alertify.core.css">
        <script src="plugins/alertify/alertify.min.js"></script>

        <!-- Social Icons -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">



        <!-- //css files -->
    </head>

    <body>
        <!-- main -->
    <html lang="en"> <!--<![endif]-->
        <head>
            <style>
                #imagen_net{

                    margin: 0;
                    max-height: 450px;
                    width: 100%;
                    padding: 0;
                    border: 0;
                    font-size: 100%;
                    font: inherit;
                    vertical-align: baseline;

                }

            </style>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <title>Login netflix admin dashboard</title>
            <link rel="stylesheet" href="./dist/login_styles/css/style.css">
            <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        </head>
        <body>
            <div   id="ppal">
                <div>
                    <img id="imagen_net" src="./dist/login_styles/img/netflix.jpg">
                </div>


                <div class="row" id="formulario">
                    <form method="post" action="seguridad/login.php" method="POST" class="login">
                        <p>
                            <label for="login">Email:</label>
                            <input type="text" name="correo" id="correo" value="correo@ejemplo.com">
                        </p>

                        <p>
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" value="4815162342">
                        </p>

                        <p class="login-submit">
                            <button id='envia' type="button" class="login-button">Ingresar</button>
                        </p>

                        <p class="forgot-password"><a href="index.html">
                                <i class="fa fa-key" aria-hidden="true"></i>  Olvidaste tu contraseña?</a></p>

                    </form>

                </div>

            </div>

        </body>

    </html>




    <!-- jQuery 2.2.3 -->
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>







        <!--  <script src="dist/js/pages/operaciones.js"></script>-->

    <script>
        $(document).ready(function () {

            $('#envia').click(function () {

                var correo = $('#correo').val();
                var password = $('#password').val();
                //alert(correo);
                //alert(password);
                console.log(correo);
                console.log(password);
                if (correo != '' && password != '') {

                    $.ajax({
                        url: 'seguridad/login.php',
                        method: 'POST',
                        data: {correo: correo, password: password},
                        success: function (data) {

                            $('#mensaje').html(data);

                        }
                    });

                } else if (correo == '' || password == '') {


                    alertify.error("Campos vacios!");

                }
            });

            $("input").keypress(function (event) {
                if (event.which == 13) {
                    event.preventDefault();
                    $('#envia').click();
                }
            });

        });


    </script>
    <div id="mensaje"></div>
</body>

</html>
