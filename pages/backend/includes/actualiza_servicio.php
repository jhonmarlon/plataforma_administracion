<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $nuevo_nombre = $_POST["nuevo_nombre"];
    $id_servicio = $_POST["id_servicio"];


    //actualizamos datos de cuenta de netflix
    $conn->updateServicio($id_servicio, $nuevo_nombre);


    $conn->cerrar();
}

