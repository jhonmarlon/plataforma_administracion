<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $user_id = $_POST["user_id"];
    $user_id_crea = $_POST["id_usuario_creo"];
    $num_cuentas = $_POST["num_cuentas"];
    $tipo_solicitud = $_POST["tipo_solicitud"];
    $descripcion_solicitud = $_POST["descripcion_solicitud"];

    //tomamos la fecha actual 
    setlocale(LC_TIME, 'es_ES.utf8', 'esp');
    date_default_timezone_set('America/Bogota');
    $fecha_actual = strftime("%Y-%m-%d %H:%M:%S");

    $conn->creaSolicitud($user_id, $user_id_crea, $fecha_actual, $num_cuentas, $tipo_solicitud, $descripcion_solicitud);

    $conn->cerrar();
}
         