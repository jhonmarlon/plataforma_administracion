<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $id_solicitud = $_POST["id_solicitud"];

    $cant_cuentas = $_POST["cant_cuentas"];

    //tomamos las cuentas actuales del usuario
    //asignamos las cuentas al usuario que solicito
    $id_usuario_solicito = $conn->conexion->query("select id_cliente_usuario from solicitud where id_solicitud='$id_solicitud'");
    $id_usu = $id_usuario_solicito->fetch_assoc();
    $id = $id_usu["id_cliente_usuario"];

    //tomamos las cuentas actuales del usuario
    $cant_cuentas_actuales = $conn->conexion->query("select num_cuentas from usuario where id_usuario='$id'");
    $cant = $cant_cuentas_actuales->fetch_array();
    //sumamos las cuentas actuales del usuario con las cuentas que solicito
    $cuentas = $cant[0] + $cant_cuentas;

    $conn->asignaCantCuentas($id, $cuentas);

    $conn->apruebaSolicitud($id_solicitud);
    //tomamos la ultima respuesta insertada
    $resp = $conn->conexion->query("select id_respuesta_solicitud from respuesta_solicitud 
    order by id_respuesta_solicitud desc limit 1;");
    $respuesta = $resp->fetch_array();
    echo $respuesta[0];

    $conn->cerrar();
}
         