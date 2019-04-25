<link rel="stylesheet" href="plugins/alertify/alertify.default.css">
<link rel="stylesheet" href="../../plugins/alertify/alertify.core.css">
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../../plugins/alertify/alertify.min.js"></script>

<style>
    .btn-success{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #3e6b2f), color-stop(1, #09bb58) );
        color: white;
        width: 150px;
        height: 32px;  
        border-radius: 3px}

    .btn-success:hover{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #408163), color-stop(1, #18a11f) );
    }

    .btn-danger{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #841b1b), color-stop(1, #ff2020) );
        color: white;
        width: 150px;
        height: 32px;
        border-color: #d73925;
        border-radius: 3px
    }
    .btn-danger:hover{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #8f0b0b), color-stop(1, #8f5151) );
        border-color: #861709;
    }


    .box.box-info {
        border-top-color: #ef0000;
    }
  .info_table {
    /* background: -webkit-linear-gradient(top, #ff1a1a 0%,#520d0d 100%); */
    color: white;
    background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #bf1c1c), color-stop(1, #010608) );
    text-align: center;
} 

    .table-bordered>thead>tr>th, .table-bordered>thead>tr>td {
        border-bottom-width: 2px;
        font-size: 20px;
        font-style: italic;
        font-weight: 51px;
    }
    input, optgroup, select, textarea {
        padding: 5px;
        font-size: 15px;
        text-shadow: 0px 1px 0px white;
        outline: none;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        border: 1px solid white;
        box-shadow: 0 -3px 4px 0px #858585,inset 0 10px 10px 1px #CFCFCF;
        border-bottom: solid 1px #AAA;
        border-left: solid 1px #AAA;
        border-right: solid 1px #AAA; 
        margin: 5px;
        /* max-width: 100%; */
        width: 100%;
    }




    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
    }


</style>
<?php $id_usuario_crea = $userinfo->user_id; ?>

<input type="hidden" id="crea_cuenta_net" value="<?php echo $id_usuario; ?>">


<?php

function printCuentasCreadas($conn, $id_usuario) {

    $consulta = "select a.*, b.id_cuenta_netflix,b.fecha_creacion as 'f_creacion_net',b.csv,b.user_netflix,b.pass_netflix,b.id_usuario,b.id_cliente,b.estado from cuenta_gmail a, 
    cuenta_netflix b where a.id_cuenta_gmail=b.id_cuenta_gmail and b.crea_cuenta='$id_usuario'
    and b.estado='1' order by a.id_cuenta_gmail desc limit 5";
    $num_cuentas = $conn->conexion->query("select count(a.id_cuenta_netflix) as 'num_cuenta' from cuenta_netflix a,usuario b where "
            . "a.id_usuario=b.id_usuario");
    $num = $num_cuentas->fetch_array();
    if ($consulta = $conn->conexion->query($consulta)) {
        $i = 1;
        while ($obj = $consulta->fetch_object()) {
            ?>
            <tr>
                <td><a class="glyphicon glyphicon-user"></a></td>
                <td><label id="fecha_gmail<?php echo $i ?>" title="<?php echo $i ?>"><?php printf($obj->fecha_creacion); ?></label></td>
                <td><label id="nombre_gmail<?php echo $i ?>"><?php printf($obj->nombre); ?></label></td>
                <td><label id="apellido_gmail<?php echo $i ?>"><?php printf($obj->apellido); ?></label></td>
                <td><label id="correo_gmail<?php echo $i ?>"><?php printf($obj->correo); ?></label></td>
                <td><label id="clave_gmail<?php echo $i ?>"><?php printf($obj->clave); ?></label></td>
                <td><label id="linea_gmail<?php echo $i ?>"><?php printf($obj->linea); ?></label></td>
                <td><label id="num_ecard_gmail<?php echo $i ?>"><?php printf($obj->num_ecard); ?></label></td>
                <td><label id="id_cunta_net<?php echo $i ?>"><?php printf($obj->id_cuenta_netflix); ?></label></td>
                <td><label id="fecha_net<?php echo $i ?>"><?php printf($obj->f_creacion_net); ?></label></td>
                <td><label id="csv_net<?php echo $i ?>"><?php printf($obj->csv); ?></label></td>
                <td><label id="user_net<?php echo $i ?>"><?php printf($obj->user_netflix); ?></label></td>
                <td><label id="pass_net<?php echo $i ?>"><?php printf($obj->pass_netflix); ?></label></td>
                <td><label id="id_usu_net<?php echo $i ?>"><?php
                        if (($obj->id_usuario) == '0') {
                            echo "<font color='red'><b>No tomada</b></font>";
                        } else {
                            
                        }
                        ?></label></td>
                <td><label id="id_cli_net<?php echo $i ?>"><?php
                        if (($obj->id_cliente) == '0') {
                            echo "<font color='red'><b>No vendida</b></font>";
                        } else {
                            
                        }
                        ?></label></td>
                <td><label id="estado_net<?php echo $i ?>"><?php
                        if (($obj->pass_netflix) != '0') {
                            echo "<font color='black'><b>Activa</b></font>";
                        } else {
                            echo "<font color='red'><b>Inactiva</b></font>";
                        }
                        ?></label></td>
                <td>
                    <a href="#" data-target="#editar_cuenta" data-toggle="modal" onclick="upd('<?php printf($obj->fecha_creacion); ?>', '<?php printf($obj->nombre); ?>',
                                                '<?php printf($obj->apellido); ?>', '<?php printf($obj->correo); ?>', '<?php printf($obj->clave); ?>', '<?php printf($obj->linea); ?>',
                                                '<?php printf($obj->num_ecard); ?>', '<?php printf($obj->id_cuenta_netflix); ?>', '<?php printf($obj->f_creacion_net); ?>',
                                                '<?php printf($obj->csv); ?>', '<?php printf($obj->user_netflix); ?>', '<?php printf($obj->pass_netflix); ?>')"
                       <button id="upda" type="submit" title="actualizar" class="btn btn-default"><i class="fa fa-refresh"></i></button>
                    </a>
                    <!--<button onclick="editar_cuenta()">Editar</button></td>-->



            </tr>
            <?php
            $i++;
            //printColaboradores($obj->cedula,$conn);
        }
        $consulta->close();
    }
}

function tabla_creacion_gmail() {
    ?>

    <table>
        <tr>
            <td><label>Fecha de creación:</label></td>
            <td><input id="f_creacion_gmail" type="date" placeholder="Fecha de creación"></td>
        </tr>
        <tr>
            <td><label>Nombre:</label></td>
            <td><input style='text-transform:uppercase;' id="nombre_gmail" type="text" placeholder="Nombre"></td>
        </tr>
        <tr>
            <td><label>Apellido:</label></td>
            <td><input style='text-transform:uppercase;' id="apellido_gmail" type="text" placeholder="Apellido"></td>
        </tr>
        <tr>
            <td><label>Correo:</label></td>
            <td><input id="correo_gmail" type="email" placeholder="CORREO"></td>
        </tr>
        <tr>
            <td><label>Clave:</label></td>
            <td><input id="clave_gmail" type="text" placeholder="CLAVE"></td>
        </tr>
        <tr>
            <td><label>Línea:</label></td>
            <td><input id="linea_gmail" type="text" placeholder="LINEA"></td>
        </tr>
        <tr>
            <td><label>Num E-card:</label></td>
            <td><input id="ecard_gmail" type="text" placeholder="E-CARD"></td>
        </tr>

    </table>
    <?php
}

//tabla gmail modal
function tabla_creacion_gmail_modal() {
    ?>

    <table>
        <tr>
            <td><label>Fecha de creación:</label></td>
            <td><input id="f_creacion_gmail_modal" type="date" placeholder="Fecha de creación"></td>
        </tr>
        <tr>
            <td><label>Nombre:</label></td>
            <td><input style='text-transform:uppercase;' id="nombre_gmail_modal" type="text" placeholder="Nombre"></td>
        </tr>
        <tr>
            <td><label>Apellido:</label></td>
            <td><input style='text-transform:uppercase;' id="apellido_gmail_modal" type="text" placeholder="Apellido"></td>
        </tr>
        <tr>
            <td><label>Correo:</label></td>
            <td><input id="correo_gmail_modal" type="email" placeholder="CORREO"></td>
        </tr>
        <tr>
            <td><label>Clave:</label></td>
            <td><input id="clave_gmail_modal" type="text" placeholder="CLAVE"></td>
        </tr>
        <tr>
            <td><label>Línea:</label></td>
            <td><input id="linea_gmail_modal" type="text" placeholder="LINEA"></td>
        </tr>
        <tr>
            <td><label>Num E-card:</label></td>
            <td><input id="ecard_gmail_modal" type="text" placeholder="E-CARD"></td>
        </tr>

    </table>
    <?php
}

function tabla_creacion_netflix() {
    ?>

    <table>
        <tr>
            <td><label>Fecha de creación:</label></td>
            <td><input id="f_creacion_net" type="date" placeholder="Fecha de creación"></td>
        </tr>
        <tr>
            <td><label>CSV:</label></td>
            <td><input id="csv_net" type="text" placeholder="CSV"></td>
        </tr>
        <tr>
            <td><label>User:</label></td>
            <td><input id="user_net" type="text" placeholder="USER"></td>
        </tr>
        <tr>
            <td><label>Pass:</label></td>
            <td><input id="pass_net" type="email" placeholder="PASS"></td>
        </tr>

    </table><br><br>

    <?php
}

function tabla_creacion_netflix_modal() {
    ?>

    <table>
        <tr>
            <td><label>Fecha de creación:</label></td>
            <td><input id="f_creacion_net_modal" type="date" placeholder="Fecha de creación"></td>
        </tr>
        <tr>
            <td><label>CSV:</label></td>
            <td><input id="csv_net_modal" type="text" placeholder="CSV"></td>
        </tr>
        <tr>
            <td><label>User:</label></td>
            <td><input id="user_net_modal" type="text" placeholder="USER"></td>
        </tr>
        <tr>
            <td><label>Pass:</label></td>
            <td><input id="pass_net_modal" type="email" placeholder="PASS"></td>
        </tr>

    </table><br><br>

    <?php
}
?>


<!-- /.row -->

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <div class="col-md-12">
        <!-- MAP & BOX PANE -->
        <div class="box box-success">
            <div class="box-header with-border">
                <div class="row" class="form-control"><h2>Nueva cuenta</h2></div><br>
                <div class="row">
                    <div class="col-md-6" >
                        <h3 style="font-family: -webkit-pictograph;" class="box-title">Información cuenta gmail asociada</h3><br><br>
                        <?php tabla_creacion_gmail() ?>
                    </div>

                    <div class="col-md-6" >
                        <h3 style="font-family: -webkit-pictograph;" class="box-title">Información cuenta Netflix</h3><br><br>

                        <?php tabla_creacion_netflix() ?>

                        <button  class="btn-success" onclick="crear_cuenta()">Crear cuenta</button>
                    </div>

                </div>

                <br><br><h3 style="font-family: -webkit-pictograph;" class="box-title">Información detallada cuentas Netflix</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool"
                            data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="row">
                    <div class="col-md-12 col-sm-8">
                      <!--  <section class="webdesigntuts-workshop">
                            <form action="" method="">		    
                                <input type="search" placeholder="What are you looking for?">		    	
                                <button>Search</button>
                            </form>


                        </section> -->                        <div class="pad">


                            <!-- Map will be created here -->
                            <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr >
                                            <td class="info_table" colspan="8">Información cuenta Gmail</td>
                                            <td class="info_table" colspan="9">Información cuenta Netflix</td>
                                        <tr>

                                        <tr>
                                            <th></th> 
                                            <!-- info cuenta gmail-->

                                            <th><strong>Fecha de creación</strong></th>
                                            <th><strong>Nombre</strong></th>
                                            <th><strong>Apellido</strong></th>
                                            <th><strong>Correo</strong></th>
                                            <th><strong>Clave</strong></th>
                                            <th><strong>Linea</strong></th>
                                            <th><strong>Num ECard</strong></th>
                                            <!-- info cuenta netflix-->
                                            <th><b>ID cuenta</b></th>
                                            <th><strong>Fecha de creación</strong></th>
                                            <th><strong>CSV</strong></th>
                                            <th><strong>User</strong></th>
                                            <th><strong>Pass</strong></th>
                                            <th><strong>Tomada</strong></th>
                                            <th><strong>Vendida</strong></th>
                                            <th><strong>Estado</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $conn = new conexion();
                                        $id_usuario = $userinfo->user_id;

                                        printCuentasCreadas($conn, $id_usuario);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.TABLA DE DATA TABLE -->
                </div>
                <!-- /.row -->
            </div>
            <div id="resultado"></div>
            <div id="resultado_1"></div>

            <!-- /.box-body -->
        </div>
    </div>
</div>

<script>

    function crear_cuenta() {
        //crea_cuenta
        var crea_cuenta = $('#crea_cuenta_net').val();
        //datos cuenta gmail
        var fecha_gmail = document.getElementById("f_creacion_gmail").value;
        var nombre_gmail = document.getElementById("nombre_gmail").value;
        var apellido_gmail = document.getElementById("apellido_gmail").value;
        var correo_gmail = document.getElementById("correo_gmail").value;
        var clave_gmail = document.getElementById("clave_gmail").value;
        var linea_gmail = document.getElementById("linea_gmail").value;
        var ecard_gmail = document.getElementById("ecard_gmail").value;
        //datos cuenta netflix
        var f_creacion_net = document.getElementById("f_creacion_net").value;
        var csv_net = document.getElementById("csv_net").value;
        var user_net = document.getElementById("user_net").value;
        var pass_net = document.getElementById("pass_net").value;

        $res = valida_campos(fecha_gmail, nombre_gmail, apellido_gmail, correo_gmail, clave_gmail,
                linea_gmail, ecard_gmail, f_creacion_net, csv_net, user_net, pass_net);

        if ($res != false) {

            alertify.confirm('Desea crear una cuenta con datos diligenciados?', function (e) {
                if (e) {

                    var parametros = {
                        "crea_cuenta": crea_cuenta,
                        "fecha_gmail": fecha_gmail,
                        "nombre_gmail": nombre_gmail,
                        "apellido_gmail": apellido_gmail,
                        "correo_gmail": correo_gmail,
                        "clave_gmail": clave_gmail,
                        "linea_gmail": linea_gmail,
                        "ecard_gmail": ecard_gmail,

                        "f_creacion_net": f_creacion_net,
                        "csv_net": csv_net,
                        "user_net": user_net,
                        "pass_net": pass_net

                    };
                    $.ajax({
                        data: parametros,
                        url: 'pages/backend/includes/ingresa_nueva_cuenta.php',
                        type: 'post',

                        success: function (response) {
                            alertify.alert("<P align=center><b>Cuenta creada correctamente!", function () {

                                window.setTimeout('location.reload()');
                            });
                            $("#resultado_1").html(response);

                        }
                    });
                } else {
                    alertify.error('Cancelado');
                }
            });


        }
    }
    //abra modal
    function editar_cuenta() {

        $('#configura_escala1').modal({show: 'false', backdrop: 'static', keyboard: false});
    }


    //pone valores de tabla en modal
    function upd(f_creacion_gmail, nombre_gmail, apellido_gmail, correo_gmail,
            clave_gmail, linea_gmail, num_ecard, id_cuenta_netflix, f_creacion_net, csv,
            user_net, pass_net) {
        //datos gmail
        $('#f_creacion_gmail_modal').val(f_creacion_gmail);
        $("#nombre_gmail_modal").val(nombre_gmail);
        $("#apellido_gmail_modal").val(apellido_gmail);
        $("#correo_gmail_modal").val(correo_gmail);
        $("#clave_gmail_modal").val(clave_gmail);
        $("#linea_gmail_modal").val(linea_gmail);
        $("#ecard_gmail_modal").val(num_ecard);

        //datos netflix
        $("#f_creacion_net_modal").val(f_creacion_net);
        $("#csv_net_modal").val(csv);
        $("#user_net_modal").val(user_net);
        $("#pass_net_modal").val(pass_net);

        //id cuenta netflix
        $("#id_cuenta_net_modal").val(id_cuenta_netflix);

    }

    function actualiza_datos_cuenta() {
//datos gmail
        var f_creacion_gmail_modal = document.getElementById("f_creacion_gmail_modal").value;
        var nombre_gmail_modal = document.getElementById("nombre_gmail_modal").value
        var apellido_gmail_modal = document.getElementById("apellido_gmail_modal").value
        var correo_gmail_modal = document.getElementById("correo_gmail_modal").value
        var clave_gmail_modal = document.getElementById("clave_gmail_modal").value
        var linea_gmail_modal = document.getElementById("linea_gmail_modal").value
        var ecard_gmail_modal = document.getElementById("ecard_gmail_modal").value
//datos netflix
        var f_creacion_net_modal = document.getElementById("f_creacion_net_modal").value;
        var csv_net_modal = document.getElementById("csv_net_modal").value;
        var user_net_modal = document.getElementById("user_net_modal").value;
        var pass_net_modal = document.getElementById("pass_net_modal").value;

        var id_cuenta_net_modal = document.getElementById("id_cuenta_net_modal").value;



        $resp = valida_campos(f_creacion_gmail_modal, nombre_gmail_modal, apellido_gmail_modal, correo_gmail_modal,
                clave_gmail_modal, linea_gmail_modal, ecard_gmail_modal, f_creacion_net_modal, csv_net_modal,
                user_net_modal, pass_net_modal, id_cuenta_net_modal);

        if ($resp != false) {
            alertify.confirm('Desea guardar los datos diligenciados para la cuenta?', function (e) {
                if (e) {
                    var parametros = {
                        "f_creacion_gmail_modal": f_creacion_gmail_modal,
                        "nombre_gmail_modal": nombre_gmail_modal,
                        "apellido_gmail_modal": apellido_gmail_modal,
                        "correo_gmail_modal": correo_gmail_modal,
                        "clave_gmail_modal": clave_gmail_modal,
                        "linea_gmail_modal": linea_gmail_modal,
                        "ecard_gmail_modal": ecard_gmail_modal,

                        "f_creacion_net_modal": f_creacion_net_modal,
                        "csv_net_modal": csv_net_modal,
                        "user_net_modal": user_net_modal,
                        "pass_net_modal": pass_net_modal,
                        "id_cuenta_net_modal": id_cuenta_net_modal

                    };
                    $.ajax({
                        data: parametros,
                        url: 'pages/backend/includes/actualiza_cuenta.php',
                        type: 'post',

                        success: function (response) {
                            alertify.alert("<P align=center><b>Cambios realizados correctamente!", function () {

                                window.setTimeout('location.reload()');
                            });
                            $("#resultado_1").html(response);

                        }
                    });
                } else {
                    alertify.error('Cancelado');
                }
            });

        }
    }

    function valida_campos(f_creacion_gmail_modal, nombre_gmail_modal, apellido_gmail_modal, correo_gmail_modal,
            clave_gmail_modal, linea_gmail_modal, ecard_gmail_modal, f_creacion_net_modal, csv_net_modal,
            user_net_modal, pass_net_modal, id_cuenta_net_modal) {

        if (f_creacion_gmail_modal == "" || nombre_gmail_modal == "" || apellido_gmail_modal == "" ||
                correo_gmail_modal == "" || clave_gmail_modal == "" || linea_gmail_modal == "" || ecard_gmail_modal == "" ||
                f_creacion_net_modal == "" || csv_net_modal == "" || user_net_modal == "" || pass_net_modal == "") {

            alertify.alert('<P align=center>Antes de guardar ,debe estar seguro de que  <font color="red"><b>Todos los campos</b></font> estén completos y correctamente diligenciados');
            return false;
        }



    }



</script>



<!-- INICIO DE MODAL CONFIGURAR CUENTA- modificar -->
<div class="modal fade" id="editar_cuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="width: 130%; border-radius:10px;" id="modalesc" class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title" id="myModalLabel_conf_1"  style="font-size:20px ;text-align: center"><b>Editar información de cuenta</b></h4>

            </div>
            <div class="modal-body" style="padding: 10%;">
                <div class="col-md-13">
                    <div class="row">
                        <div class="col-md-6" >
                            <h3 style="font-family: -webkit-pictograph;" class="box-title">Información cuenta gmail asociada</h3><br><br>
                            <?php tabla_creacion_gmail_modal(); ?>
                        </div>

                        <div class="col-md-6" >
                            <h3 style="font-family: -webkit-pictograph;" class="box-title">Información cuenta Netflix</h3><br><br>

                            <?php tabla_creacion_netflix_modal(); ?>
                            <input type="hidden" id="id_cuenta_net_modal">


                        </div>
                        <div class="row">
                            <div class="col-md-3" >
                                <button  class="btn-success" onclick="actualiza_datos_cuenta()">Guardar cambios</button>

                            </div>
                            <div class="col-md-3" >
                                <button  id="cancelar" class="btn-danger" data-dismiss="modal" aria-hidden="true">Cencelar</button>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <!-- FIN DE MODAL -->

