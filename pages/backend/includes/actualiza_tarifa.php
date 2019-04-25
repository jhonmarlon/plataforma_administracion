<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();
  
    $id_actualizar = $_POST["id_actualizar"];
    $tarifa = $_POST["tarifa"];
    $tipo_tarifa = $_POST["tipo_tarifa"];


    $conn->actualizaTarifaTemp($id_actualizar, $tarifa,$tipo_tarifa);

    $conn->cerrar();
}

