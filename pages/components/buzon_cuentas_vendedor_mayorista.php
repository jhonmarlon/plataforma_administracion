<link rel="stylesheet" href="plugins/alertify/alertify.default.css">
<link rel="stylesheet" href="../../plugins/alertify/alertify.core.css">
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../../plugins/alertify/alertify.min.js"></script>
<link rel="stylesheet" href="dist/css/check_radio/magic-check.css">

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'pages/components/metricas_distribuidor.php';

$conn = new conexion();
$user_id = $userinfo->user_id;
$cuentas_usuario = $conn->conexion->query("select a.id_cuenta_netflix_act,a.usuario,"
        . "a.clave,a.fecha_creacion,b.fecha_asignacion from cuenta_netflix_act a,"
        . " cuenta_usuario b where b.id_cuenta_netflix_act=a.id_cuenta_netflix_act "
        . "and b.id_usuario='$user_id' and b.estado='1' order by a.fecha_creacion,b.fecha_asignacion desc");

if (mysqli_num_rows($cuentas_usuario) == 0) {

    echo "<script> alertify.alert('<P align = center><b>No tienes cuentas asignadas en el buzón de cuentas.', function () { location.href='index.php'; }); </script>";

    return;
}

?>

<input type="hidden" id="user_id" value="<?php echo $user_id ?>">

<div class="datagrid">
    <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
        <table id="tbl_cuentas_netflix">
            <thead style="width: 100%">
                <tr>
                    <th><label>N° Cuenta</label></th>
                    <th><label>Usuario</label></th>
                    <th><label>Clave</label></th>
                    <th><label>Fecha Creación</label></th>
                    <th><label>Fecha Asignación</label></th>
                    <th><label>Asignar Cuenta</label><th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($res = $cuentas_usuario->fetch_assoc()) {
                    ?>

                    <tr>
                        <td><label title="<?php echo $i ?>" id="id_cuenta_net<?php echo $i ?>"><?php echo $res["id_cuenta_netflix_act"] ?></label></td>
                        <td><label id="usuario<?php echo $i ?>"><?php echo $res["usuario"] ?></label></td>
                        <td><label id="clave<?php echo $i ?>"><?php echo $res["clave"] ?></label></td>
                        <td><label id="fecha_creacion<?php echo $i ?>"><?php echo $res["fecha_creacion"] ?></label></td>
                        <td><label id="fecha_asignacion<?php echo $i ?>"><?php echo $res["fecha_asignacion"] ?></label></td>  
                        <td> <input type="checkbox" id="check<?php echo $i ?>" title="Asignar Cuenta" ><img src="dist/img/netflix_icono.png" /></td>

                    </tr>

                    <?php
                    $i++;
                }
                ?>                         
            </tbody>

        </table><br><br>

    </div>
            <button type="button" name="asignar_cuentas" class="btn btn-success" onclick="asignar_cuenta()">Asignar cuentas</button>

    <!--<input type="text" id="resultado_asignacion"> -->
    <div id="resultado_asignacion"></div>
</div>

<script>

    function asignar_cuenta() {

        //Tomamos el numero de filas de la tabla
        var num_filas = document.getElementById("tbl_cuentas_netflix").rows.length;

        var cuentas = "";
        for (var i = 1; i < num_filas; i++) {
            if ($('#check' + i).prop('checked')) {

                cuenta = document.getElementById("id_cuenta_net" + i).innerHTML;
                cuentas += cuenta + ",";
            }
        }

        if (cuentas == "") {
            alertify.alert('<P align=center><b>No se ha elegido ninguna cuenta ,<br> Inténtalo nuevamente.</b>');
            return;
        }
        // pasamos las cuentas seleccionadas al input hidden del modal
        $('#cuentas_a_asignar').val(cuentas);


        $("#asignar_cuenta").modal();

    }




    //ASIGNAR LAS CUENTAS ELEGIDAD AL CLIENTE ELEGIDO
    function asignar_cuenta_cliente() {
        var id_cliente = document.getElementById("clientes_finales").value;
        /*var tipo_pago = $("input[name='forma_pago']:checked").val();
         
         if (tipo_pago == undefined) {
         alertify.alert('<b>Es necesario especificar un tipo de pago.</b>');
         return;
         }*/

        if (id_cliente == 0) {
            alertify.alert('<P align=center><b>Antes de asignar las cuentas ,<br>debe elegir al cliente.</b>');
            return;
        }

        //enviamos los datos para poder asignar las cuentas al usuario elegido
        alertify.confirm('Desea asignar las cuentas seleccionadas al cliente elegido?', function (e) {
            if (e) {
                $("#asignar_cuenta").modal('hide');

                $('#abono').modal();

            } else {
                alertify.error('Cancelado');
            }
        });
    }



</script>




<!--INICIO MODAL ASIGNAR CUENTAS-->

<div class="modal fade" style="overflow-y: scroll; overflow-x: scroll" id="asignar_cuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="width: 130%; border-radius:10px;" id="modalesc" class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title" id="myModalLabel_conf_1"  style="font-size:20px ;text-align: center"><b>Asignación de cuentas</b></h4>

            </div>
            <div class="modal-body" style="padding: 5%;">
                <div class="row">

                    <div class="col-md-6">
                        <h3 style="font-family: -webkit-pictograph;" class="box-title">Cliente a asignar las cuentas seleccionadas</h3>
                        <?php
                        $conn = new conexion();
                        $clientes = $conn->conexion->query("SELECT a.id_cliente,a.nombre,a.apellido from cliente a, 
                                usuario_cliente b where a.id_cliente=b.id_cliente and b.id_usuario='$user_id' and b.estado='1' 
                                order by nombre asc");
                        ?>
                        <input type="hidden" id="cuentas_a_asignar">
                        <!-- <label>Crédito</label>
                         <input type="radio" id="tipo_pago" name="forma_pago" value="credito">
                         <label>Contado</label>
                         <input type="radio" id="tipo_pago" name="forma_pago" value="contado"> -->
                        <br>
                        <select style="width: 100%" class="form-control" id="clientes_finales" name="state">
                            <option value="0" disabled selected>Seleccionar Cliente</option>                                
                            <?php while ($cli = $clientes->fetch_assoc()) { ?>
                                <option value="<?php echo $cli["id_cliente"] ?>"><?php echo $cli["nombre"] . " " . $cli["apellido"] ?></option>
                            <?php } ?>
                        </select><br><br>
                        <?php $conn->cerrar() ?>

                    </div>

                    <div class="col-md-6" style="text-align: center">
                        <label style="color: red"><b>¡IMPORTANTE!</b></label><br>
                        <label>Antes de asignar una cuenta es necesario que verifique la fecha de creación,
                            recuerde que entre más reciente sea la cuenta , el tiempo de duración es mas satisfactorio para los clientes.
                        </label>
                    </div>
                </div>
                <div class="row">
                    <button type="button" name="asignar_cuentas" class="btn btn-success" onclick="asignar_cuenta_cliente()">Asignar cuentas</button>
                    <button data-dismiss="modal" aria-hidden="true" type="button" class="btn btn-danger">Cancelar</button>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- FIN DE MODAL -->


<!--INICIO MODAL ABONO CUENTAS-->

<div class="modal fade" style="overflow-y: scroll; overflow-x: scroll" id="abono" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="width: 130%; border-radius:10px;" id="modalesc" class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title" id="myModalLabel_conf_1"  style="font-size:20px ;text-align: center"><b>Registrar pago de cliente</b></h4>

            </div>
            <div class="modal-body" style="padding: 5%;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                                <input class="magic-radio" type="radio" name="tipo_pago" id="1" value="pago">
                                <label for="1">Pagó</label>
                            </div>
                            <div class="col-md-3">
                                <input class="magic-radio" type="radio" name="tipo_pago" id="2" value="abono">
                                <label for="2">Abonó</label>
                            </div><br>
                        </div>
                        <br>
                        <div>
                            <label>Monto pagado por el cliente</label>
                            <div class="input-group"> 
                                <span class="input-group-addon">$</span>
                                <input disabled type="number"  id="monto_pagado" class="form-control" style="width: 100%;">
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div>    
                                <input class="magic-checkbox" type="checkbox" name="layout" id="enviar_correo" value="option">
                                <label for="enviar_correo">Enviar cuentas por correo electrónico</label>
                            </div><br>
                            <div>    
                                <label>Enviar cuentas via:</label><br>
                                <button disabled id="btn_facebook"  class="btn btn-default" 
                                        onclick="envia_face()" title="Enviar via Messenger" ><img style="width: 100px;" src="dist/img/messenger.jpg" /></button>
                                <button disabled id="btn_whatsapp"  class="btn btn-default" 
                                        onclick="envia_whatsapp()" title="Enviar via Whatsapp" ><img style="width: 100px;" src="dist/img/whatsapp_icono.jpeg" /></button>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <button type="button" class="btn btn-success" onclick="realizar_pago_cliente()">Registrar pago</button>
                    <button data-dismiss="modal" aria-hidden="true" type="button" class="btn btn-danger">Cancelar</button>

                </div>
            </div>
        </div>

        <div class="modal-footer"></div>
    </div>
</div>


<script>


    $("#2").on("click", function () {
        $('#monto_pagado').removeAttr("disabled");
        //habilitamos botones de envio 
        $('#btn_facebook').removeAttr("disabled");
        $('#btn_whatsapp').removeAttr("disabled");
    });

    $("#1").on("click", function () {
        $('#monto_pagado').val("");
        $('#monto_pagado').attr('disabled', 'disabled');
        //habilitamos botones de envio
        $('#btn_facebook').removeAttr("disabled");
        $('#btn_whatsapp').removeAttr("disabled");
    });



    function realizar_pago_cliente() {

        var tipo_pago = $("input[name='tipo_pago']:checked").val();
        var abono = document.getElementById("monto_pagado").value;
        alert(tipo_pago);


        //validaciones

        if (tipo_pago == undefined) {
            alertify.alert('<b>Es necesario especificar un tipo de pago.</b>');
            return;
        } else if (tipo_pago == "abono") {
            if (abono == "") {
                alertify.alert('<b>Es necesario especificar el abono realizado por el cliente.</b>');
                return;

            }
        }



        //tomamos los datos para poder crear el detalle de la venta al cliente
        var id_cuentas = document.getElementById("cuentas_a_asignar").value;
        var id_cliente = document.getElementById("clientes_finales").value;
        var id_usuario = document.getElementById("user_id").value;

        alert(id_cuentas + " cuentas");
        alert(id_cliente + " cliente");
        alert(id_usuario + " usuario");

        var parametros = {
            "id_cuentas": id_cuentas,
            "id_cliente": id_cliente,
            "id_usuario": id_usuario,
            "abono":abono,
            "tipo_pago":tipo_pago
            //"tipo_pago": tipo_pago

        };
        $.ajax({
         data: parametros,
         url: 'pages/backend/includes/asigna_cuenta_cliente.php',
         type: 'post',
         success: function (response) {
         $('#resultado_asignacion').html(response);
         alertify.alert("<P align=center><b>Cuentas asignadas correctamente!", function () {
         
         window.setTimeout('location.reload()');
         });
         }
         });
    }

</script>