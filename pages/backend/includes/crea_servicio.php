<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $nombre_servicio = $_POST["nombre_servicio"];
    echo $nombre_servicio;
    
    $conn->creaServicio($nombre_servicio);

   $conn->cerrar();
}
         