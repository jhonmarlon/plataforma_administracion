<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {
    include '../../../modelo/conexion.php';
    $conn = new conexion();

    $id_respuesta_solicitud = $_POST["id_respuesta_solicitud"];
    $monto_pagado = 0;

    setlocale(LC_TIME, 'es_ES.utf8', 'esp');
    date_default_timezone_set('America/Bogota');
    //fecha actual - fecha de compra
    $fecha = strftime("%Y-%m-%d %H:%M:%S");
    $cant_cuentas = $_POST["cant_cuentas"];

    $valor_uni = $_POST["valor_uni"];
    // quitamos el signo $ de la variable valor_uni
    $valor_unitario = str_replace("$", "", $valor_uni);
    echo "La cadena resultante es: " . $valor_unitario;

    $total_pagar = $_POST["total_pagar"];
    //quitamos el signo $ de la variable total_pagar
    $total = str_replace("$", "", $total_pagar);
    echo "La cadena resultante total es: " . $total;

    $valor_unitario_usuario = $_POST["valor_uni_usuario"];
    //ganancia
    $ganancia = $total - ($valor_unitario_usuario * $cant_cuentas);

    $tipo_pago = $_POST["tipo_pago"];
echo $valor_unitario_usuario;
    echo $id_respuesta_solicitud . "<br>";
    echo $cant_cuentas . "<br>";
    echo $fecha . "<br>";
    echo $valor_uni . "<br>";
    echo $total_pagar . "<br>";
    echo $tipo_pago . "<br>";
    echo $ganancia . " esta es la ganancia";

    $conn->creaDetalleSolicitudVendedor($id_respuesta_solicitud, $fecha, $cant_cuentas, $valor_unitario, $total, $ganancia, $tipo_pago);

    $conn->cerrar();
}

