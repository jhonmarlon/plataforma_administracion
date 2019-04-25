
<link rel="stylesheet" href="plugins/alertify/alertify.default.css">
<link rel="stylesheet" href="../../plugins/alertify/alertify.core.css">
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../../plugins/alertify/alertify.min.js"></script>

<?php
include 'pages/components/metricas_administrador_operacion.php';

$conn = new conexion();

$solicitudes_pendientes = $conn->conexion->query("select a.id_solicitud_cuenta_operacion,"
        . "b.nombre,b.apellido,c.descripcion,b.correo,b.id_usuario,a.num_cuentas,"
        . "a.fecha_solicitud,a.estado from solicitud_cuenta_operacion a,"
        . "usuario b,rol c where a.id_usuario_compra=b.id_usuario and "
        . "b.id_rol=c.id_rol order by fecha_solicitud desc");
?>

<div class="row">
    <!-- Left col -->
    <div class="col-md-12">
        <!-- MAP & BOX PANE -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Solicitudes Pendientes</h3>

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
                        <div class="pad">
                            <div class="datagrid">

                                <!-- Map will be created here -->
                                <table class="table table-striped table-bordered table-hover"
                                       id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>N° Solicitud</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Correo</th>
                                            <th>Rol</th>
                                            <th>N° Cuentas</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Tomar</th>
                                            <th>Negar</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $aux = 1;
                                        while ($res = $solicitudes_pendientes->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <th><label id="id_solicitud<?php echo $aux ?>"><?php echo $res["id_solicitud_cuenta_operacion"] ?></label></th>
                                                <th><label id="nombre<?php echo $aux ?>"><?php echo $res["nombre"] ?></label></th>
                                                <th><label id="apellido<?php echo $aux ?>"><?php echo $res["apellido"] ?></label></th>
                                                <th><label id="correo<?php echo $aux ?>"><?php echo $res["correo"] ?></label></th>
                                                <th><label id="descripcion_rol<?php echo $aux ?>"><?php echo $res["descripcion"] ?></label></th>	
                                                <th><label id="num_cuentas<?php echo $aux ?>"><?php echo $res["num_cuentas"] ?></label></th>
                                                <th><label id="fecha_solicitud<?php echo $aux ?>"><?php echo $res["fecha_solicitud"] ?></label></th>
                                                <td>
                                                    <?php
                                                    if ($res["estado"] == '1') {
                                                        echo "<b><font color='red'>Pendiente</font></b>";
                                                    }
                                                    ?>
                                                </td>   
                                                <td><a><input onclick="tomar('<?php echo $res["id_solicitud_cuenta_operacion"] ?>', '<?php echo $res["id_usuario"] ?>',
                                                                    '<?php echo $res["nombre"] ?>', '<?php echo $res["apellido"] ?>',
                                                                    '<?php echo $res["correo"] ?>', '<?php echo $res["num_cuentas"] ?>',
                                                                    '<?php echo $aux ?>')"
                                                              type="image" src="dist/img/checkmark.svg"></a></td>
                                                <td><a><input onclick="desaprobar(<?php echo $res["id_solicitud"] ?>)"
                                                              type="image" src="dist/img/cross.svg"></a></td>

                                            </tr>
                                            <?php
                                            $aux ++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                            </div>
                            <!-- /.TABLA DE DATA TABLE -->


                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>





            <!-- /.col -->
        </div>
    </div>
</div>


<script>
    function tomar(id_solicitud, id_usuario, nombre, apellido, correo, num_cuentas, aux) {

        alert(id_solicitud + "," + id_usuario + "," + nombre + "," + apellido + "," + correo + "," + num_cuentas + "," + aux);

        alertify.confirm('<b>Desea, tomar la actual solicitud?<p> En caso de tomarla , recuerde que entre más pronto la gestione, mas satisfecho estará el cliente!<b>', function (e) {
            if (e) {
                $("#nom_ape").text(" " + nombre + " " + apellido);
                $("#correo").text(" " + correo);
                $("#num_cuentas").text(" " + num_cuentas);

                $('#id_solicitud').val(id_solicitud);
                $('#id_usuario').val(id_usuario);


                //setea valores en modal
                /* 
                 $("#cedula").text(cedula);
                 $("#auxiliar").val(aux);*/
                //abre ventana modal
                $('#toma_solicitud').modal('show');

                /*  var parametros = {
                 "id_solicitud": id_solicitud,
                 "id_usuario": id_usuario
                 };
                 $.ajax({
                 data: parametros,
                 url: 'pages/backend/asignar_cuenta_solicitud_operacion.php',
                 type: 'post',
                 success: function (response) {
                 /*  alertify.alert("<P align=center><b>Solicitud enviada correctamente!", function () {
                 
                 window.setTimeout('location.reload()');
                 });
                 $('#resultado').html(response);
                 
                 }
                 });*/


            } else {
                alertify.error('Cancelado');
            }
        });
    }
</script>



<!-- INICIO DE MODAL ESTADO DE CUENTA-  -->
<div class="modal fade" id="toma_solicitud" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="width: 130%; border-radius:10px;" id="modalesc" class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title" id="myModalLabel_conf_1"  style="font-size:20px ;text-align: center"><b>Estado de cuenta</b></h4>

            </div>
            <div class="modal-header" style="color: ghostwhite;  background: -webkit-linear-gradient(top, #333333 0%,#0B0B0B 100%);">

                <div class="container">

                    <h2>Datos del cliente:</h2>
                    <input type="hidden"  id="id_solicitud">
                    <input type="hidden" id="id_usuario">
                    <input type="hidden" id="auxiliar">
                    <ul>
                        <li>
                            <label for="f-option">Nombres y apellidos: </label>
                            <label id="nom_ape"></label>  
                        </li>
                        <li>
                            <label for="s-option">Correo: </label>
                            <label id="correo"></label>  

                        </li>
                        <li>
                            <label for="s-option">Número de cuentas solicitadas: </label>
                            <label id="num_cuentas"></label>  

                        </li>




                    </ul>
                </div>


            </div>
            <div class="modal-body" style="padding: 5%;">

                <div class="col-md-13">
                    <div class="row">
                        <div class="datagrid">
                            <div style=" width: 101.5%; height:280px; overflow-y: scroll;">

                                <table id="tbl_cuentas_netflix" class="table table-striped table-bordered">
                                    <thead>

                                        <tr>                                            <!-- info cuenta gmail-->
                                            <th></th>
                                            <!-- info cuenta netflix-->
                                            <th><b>ID cuenta</b></th>
                                            <th><strong>Fecha de creación</strong></th>
                                            <th><strong>User</strong></th>
                                            <th><strong>Pass</strong></th>                                         
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
                                <button  class="btn-success" onclick="asignar_cuenta()">Asignar cuentas</button>
                                <button  id="cancelar" class="btn-danger" data-dismiss="modal" aria-hidden="true">Cencelar</button>

                            </div>

                        </div>
                        <div id="resultado"></div>
                    </div><br><br>

                </div>

                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>
<!-- FIN DE MODAL -->


<?php

function printCuentasCreadas($conn, $id_usuario) {
    //lista de usuarios
    $consulta = "select * from cuenta_netflix_act where id_usuario_crea='$id_usuario' and estado='1' order by id_cuenta_netflix_act desc";
    echo "<label>Mis cuentas disponibles</label>";
    if ($consulta = $conn->conexion->query($consulta)) {
        $i = 1;
        while ($obj = $consulta->fetch_object()) {
            ?>
            <tr>
                <td><input id="check<?php echo $i ?>" type="checkbox" name="check" required></td>
                <td><label id="id_cuenta_net<?php echo $i ?>"><?php printf($obj->id_cuenta_netflix_act); ?></label></td>
                <td><label id="fecha_net<?php echo $i ?>"><?php printf($obj->fecha_creacion); ?></label></td>
                <td><label id="user_net<?php echo $i ?>"><?php printf($obj->usuario); ?></label></td>
                <td><label title="<?php echo $i ?>" id="pass_net<?php echo $i ?>"><?php printf($obj->clave); ?></label></td>

                <td><label id="estado_net<?php echo $i ?>"><?php
                        if (($obj->estado) != '0') {
                            echo "<font color='green'><b>Activa</b></font>";
                        } else {
                            echo "<font color='red'><b>Inactiva</b></font>";
                        }
                        ?></label></td>
                <td>
                    <!--<button onclick="editar_cuenta()">Editar</button></td>-->

                </td>


            </tr>

            <?php
            $i++;
            //printColaboradores($obj->cedula,$conn);
        }
        $consulta->close();
    }
}
?>


<script>
    function asignar_cuenta() {

        //Tomamos el numero de filas de la tabla
        var num_filas = document.getElementById("tbl_cuentas_netflix").rows.length;
        var id_vend=document.getElementById("id_usuario").value;
        alert(id_vend);
        alert(num_filas);

        var id_cuentas = "";
        for (var i = 1; i < num_filas; i++) {
            if ($('#check' + i).prop('checked')) {

                cuenta = document.getElementById("id_cuenta_net" + i).innerHTML;
                id_cuentas += cuenta + ",";
            }
        }

        alert(id_cuentas);
        if (id_cuentas == "") {
            alertify.alert('<P align=center><b>No se ha elegido ninguna cuenta ,<br> Inténtalo nuevamente.</b>');
            return;
        }
        // pasamos las cuentas seleccionadas al input hidden del modal
        $('#cuentas_a_asignar').val(cuentas);
        /*if (i == (num_filas - 1)) {
         cuenta = document.getElementById("id_cuenta_net" + i).innerHTML;
         cuentas += cuenta+".";
         
         } else {
         alert(i);
         cuenta = document.getElementById("id_cuenta_net" + i).innerHTML;
         cuentas += cuenta + ",";
         }*/





        //creamos array donde estaran las cuentas seleccionadas
        /* var cuentas = new Array();
         var cuenta;
         
         i = 1;
         
         for (i; i < num_filas; i++) {
         if ($('#check' + i).prop('checked')) {
         alert(i);
         cuenta = document.getElementById("id_cuenta_net" + i).innerHTML;
         cuentas.push(cuenta);
         }
         }
         
         //enviamos 
         if (cuentas.length == 0) {
         alertify.alert('<P align=center><b>No se ha elegido ninguna cuenta ,<br> Inténtalo nuevamente.</b>');
         return;
         }*/



        $("#asignar_cuenta").modal()

    }

</script>