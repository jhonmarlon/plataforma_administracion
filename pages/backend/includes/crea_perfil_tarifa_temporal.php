<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $nombre_perfil = $_POST["nombre_perfil"];
    $id_usuario = $_POST["id_usuario"];
    $id_empresa = $_POST["id_empresa"];
    $id_servicio = $_POST["id_servicio"];
    $tarifa = $_POST["tarifa"];
    
    
    $conn->creaPerfilTarifaTemp($nombre_perfil, $id_usuario, $id_empresa, $id_servicio, $tarifa);

    $conn->cerrar();
}
         