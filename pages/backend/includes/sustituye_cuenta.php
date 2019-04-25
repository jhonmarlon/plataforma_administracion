<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    echo "ya estoy";

    $id_cuenta_ant = $_POST["id_cuenta_ant"];
    $usuario_nueva_cuenta = $_POST["usuario_nueva_cuenta"];
    $clave_nueva_cuenta = $_POST["clave_nueva_cuenta"];


    //validamos que la cuenta exista o no en la base de datos.
    $existe = $conn->getCountExisteCuenta($usuario_nueva_cuenta);
    $existe_cuenta = $existe->fetch_array();
    echo $existe_cuenta[0];
    if ($existe_cuenta != 0){
        
        
    }
}
