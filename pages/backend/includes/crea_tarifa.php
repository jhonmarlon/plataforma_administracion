<?php

session_start();

if ($_SESSION['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();
    $tipo_tarifa = $_POST["tipo_tarifa"];

    $codigo = $conn->encryption($_POST['codigo']);
    $valor = $_POST['valor'];
    $tipo_tarifa = $_POST["tipo_tarifa"];
    $tipo_usuario = $_POST["tipo_usuario"];
    $id_usuario = $_POST["id_usuario"];
    $id_empresa=$_POST["id_empresa"];
    
    $conn->insertTarifa($codigo, $valor, $tipo_tarifa,$tipo_usuario,$id_usuario,$id_empresa);

    $conn->cerrar();
}

