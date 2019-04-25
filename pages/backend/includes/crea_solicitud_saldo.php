<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    //usuario que realiza la peticion
    $user_id = $_POST["user_id"];
    //usuario responsable
    $user_id_crea = $_POST["id_usuario_creo"];

    //saldo_solicitado
    $saldo_solicitado = $_POST["saldo_solicitado"];

    //verificamos si el usuario es creado por el admin o por algun otro vendedor
    $rol_usuario_crea = $conn->conexion->query("SELECT id_rol from usuario "
            . "where id_usuario='$user_id_crea'");
    $id_rol = $rol_usuario_crea->fetch_array();

    //tomamos la fecha actual para tener la fecha de la solicitud
    setlocale(LC_TIME, 'es_ES.utf8', 'esp');
    date_default_timezone_set('America/Bogota');
    $fecha_actual = strftime("%Y-%m-%d %H:%M:%S");


    //si el usuario es creado por el administrador
    if ($id_rol[0] == '1') {


        //verificamos el estado de cuenta del usuario
        $sum_detalle = $conn->getSumDetalle($user_id);
        $suma_detalle = $sum_detalle->fetch_array();

        //Si el estado de cuenta es menor al monto permitido de saldo + 10%,
        //la solicitud se realiza automaticamente
        $saldo_max_perm = $conn->getSaldoMaximoPermitido($user_id);
        $saldo_max_permitido = $saldo_max_perm->fetch_array();
        $saldo_mas_porciento = $saldo_max_permitido[0] + ($saldo_max_permitido[0] * 0.1);
        //validamos que el estado de cuenta , sea menos al saldpo permitido + 10%
        if ($suma_detalle[0] < $saldo_mas_porciento) {
            //tomamos el saldo actual del usuario
            $saldo_act = $conn->getSaldoActual($user_id);
            $saldo_actual = $saldo_act->fetch_array();
            //saldo actual mas saldo pedido
            $nuevo_saldo = $saldo_actual[0] + $saldo_solicitado;

            $val = validaSaldoPedido($nuevo_saldo, $saldo_max_permitido[0], $saldo_actual[0]);

            if ($val == 0) {
                return;
            }
            //se realiza la asignaciond e saldo automaticamente
            $conn->actualizaSaldoUsuarioPri($user_id, $nuevo_saldo);

            //crea el registro de la solicutd realizada
            $conn->creaSolicitudSaldo($user_id, $saldo_solicitado, $fecha_actual);
            echo "<script> 
                  alertify.alert('<b>El saldo solicitado se le ha asignado correctamente!</b>',function () {window.setTimeout('location.reload()');});
            </script>";
        } else {
            //Muestra mensaje de que nos se puede pedir mas hasta que no realice 
            //algun abono
            muestraMensajeAbono();
        }
    } else {
        //si es creado por otro vendedor
        //verificamos el estado de cuenta del usuario
        $sum_detalle = $conn->getSumDetalle($user_id);
        $suma_detalle = $sum_detalle->fetch_array();

        //Si el estado de cuenta es menor al monto permitido de saldo + 10%,
        //la solicitud se realiza automaticamente
        $saldo_max_perm = $conn->getSaldoMaximoPermitido($user_id);
        $saldo_max_permitido = $saldo_max_perm->fetch_array();
        $saldo_mas_porciento = $saldo_max_permitido[0] + ($saldo_max_permitido[0] * 0.1);
        //validamos que el estado de cuenta , sea menos al saldpo permitido + 10%
        if ($suma_detalle[0] < $saldo_mas_porciento) {
            //tomamos el saldo actual del usuario
            $saldo_act = $conn->getSaldoActual($user_id);
            $saldo_actual = $saldo_act->fetch_array();
            //saldo actual mas saldo pedido
            $nuevo_saldo = $saldo_actual[0] + $saldo_solicitado;

            $val = validaSaldoPedido($nuevo_saldo, $saldo_max_permitido[0], $saldo_actual[0]);

            if ($val == 0) {
                return;
            }

            //validamos el saldo que tiene el usuario creador
            $saldo_creador = $conn->getSaldoActual($user_id_crea);
            $saldo_act_usuario_crea = $saldo_creador->fetch_array();

            //verificamos que el usuario creador si tenga el monto requerido
            if ($saldo_solicitado > $saldo_act_usuario_crea[0]) {
                echo "<script> 
                  alertify.alert('<b>Tu proveedor <font color=red>No</font> posee saldo suficiente para'+
                  ' cumplir con tu solicitud.<p>Intenta con un valor mas bajo, de lo contrario te sugerimos que te comuniques directamente con él.</b>');
            </script>";
                return;
            }

            //en caso de que si , tomamos el valor y lo restamos al saldo del creador
            $conn->actualizaSaldoUsuarioPri($user_id, $nuevo_saldo);
            //restamos el monto pedido al usuario responsable
            $conn->restaSaldoActualUsuarioPri($user_id_crea, $saldo_solicitado);
            //crea el registro de la solicutd realizada
            $conn->creaSolicitudSaldo($user_id, $saldo_solicitado, $fecha_actual);
            echo "<script> 
                  alertify.alert('<b>El saldo solicitado se le ha asignado correctamente!</b>',function () {window.setTimeout('location.reload()');});
            </script>";
        } else {
            muestraMensajeAbono();
        }
    }

    $conn->cerrar();
}

//funcion que valida que el saldo pedido sea menor al permitido
function validaSaldoPedido($nuevo_saldo, $saldo_max_perm, $saldo_actual) {
    //validamos que el saldo pedido , sea menor o igual al permitido 
    if ($nuevo_saldo > $saldo_max_perm) {
        echo "<script> 
                  alertify.alert('<P align=center><b><font color=red>¡IMPORTANTE!</font>'+
                  '<p>Según su saldo actual, usted tiene permitido sólo solicitar $ '+($saldo_max_perm - $saldo_actual)+
                  '<p>Por favor inténtelo nuevamente.');
            </script>";

        return 0;
    } else {
        return 1;
    }
}

function muestraMensajeAbono() {
    echo "<script> 
                  alertify.alert('<P align=center><b><font color=red>¡IMPORTANTE!</font>'+
                  '<p>Antes de realizar una petición de saldo, es necesario que se ponga a paz y salvo, o realice un abono, le sugerimos que revise su estado de cuenta para más información.<p>'+
                  ' Comuníquese con su proveedor o directamente con la administración, de lo contrario, '+
                  '<font color=red>NO</font> se le asignará el saldo solicitado.', 
                  function () {

                            window.setTimeout('location.reload()');
                        });
            </script>";
}
