<style>
    #cambiar_pass{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0c4886), color-stop(1, #0b84ff) );
        color: white;
        width: 150px;
        height: 32px;
    }

    #cerrar_sesion{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #841b1b), color-stop(1, #ff2020) );
        color: white;

    }
    
    .main-header .navbar{
        margin-left: 0px !important; 
    }
</style>
<?php

?>
<header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo" style="background: url(dist/img/fondo_metal_rojo.jpg)">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">GTI</span>
        <!-- logo for regular state and mobile devices -->
        <!--<span class=><img id="logoarusheader" src="dist/img/aruslogo-footer.png" alt=""> <small>GTI</small></span>-->
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" >
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu" >
                    <a href="#" class="dropdown-toggle"  data-toggle="dropdown">
                        <?php if($userinfo->id_rol == 2){ ?>
                        <img src="dist/img/gerente.png" class="user-image" alt="User Image">
                        <?php } ?>
                        <span class="hidden-xs"><?php echo $userinfo->nombre." ".$userinfo->apellido; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="background: url(dist/img/fondo_metal_rojo.jpg)">
                            <img src="dist/img/gerente.png" class="img-circle" alt="User Image">

                            <p >
                                <?php
                                 if ($userinfo->id_rol == "1") {
                                    echo "Super Usuario <br>";
                                } elseif ($userinfo->id_rol == "2") {
                                    echo "Gerente/Núcleo Principal <br><b>".$userinfo->nombre_empresa."</b>";
                                }elseif ($userinfo->id_rol == "3") {
                                    echo "Gerente/Distribuidor <br><b>".$userinfo->nombre_empresa."</b>";
                                } elseif ($userinfo->id_rol == "4") {
                                    echo "Coordinador <br><b>".$userinfo->nombre_empresa."</b>";
                                }elseif ($userinfo->id_rol == "5") {
                                    echo "Asesor <br><b>".$userinfo->nombre_empresa."</b>";
                                }
                                ?>
                                <br>
                                                                <?php echo "Código Personal: ".$userinfo->codigo?>

                            </p>

                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="index.php?page=007" id="cambiar_pass" class="btn btn-success btn-flat">Cambiar Contraseña</a>

                                <a href="seguridad/salida.php" id="cerrar_sesion" class="btn btn-default btn-flat">Cerrar sesión</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
