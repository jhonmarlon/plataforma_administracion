<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();
    
    $id_eliminar = $_POST["id_eliminar"];
    $tipo_tarifa = $_POST["tipo_tarifa"];
  
    $conn->eliminaTarifa($id_eliminar, $tipo_tarifa);

    $conn->cerrar();
}
         