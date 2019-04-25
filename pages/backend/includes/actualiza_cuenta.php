<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    //netflix
    $nuevo_usuario_netflix = $_POST["nuevo_usuario_netflix"];
    $nueva_clave_netflix = $_POST["nueva_clave_netflix"];
    $cuenta_modificar = $_POST["cuenta_modificar"];

    //actualizamos datos de cuenta de netflix
    $conn->updateCuentaNetflixAct($cuenta_modificar,$nuevo_usuario_netflix, $nueva_clave_netflix);
   

    $conn->cerrar();
}

