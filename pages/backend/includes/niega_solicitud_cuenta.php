<?php

session_start();

if ($_SESSION['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $id_solicitud_negada = $_POST['id_solicitud_negada'];
    $detalle_negacion = $_POST['detalle_negacion'];

    $conn->niegaSolicitud($id_solicitud_negada, $detalle_negacion);
    $conn->cerrar();
}

