<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {
    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $nombre_cliente = $_POST["nombre_cliente"];
    $apellido_cliente = $_POST["apellido_cliente"];
    $cedula_cliente = $_POST["cedula_cliente"];
    $correo_cliente = $_POST["correo_cliente"];
    $direccion_cliente = $_POST["direccion_cliente"];
    $telefono_cliente = $_POST["telefono_cliente"];
    $celular_cliente = $_POST["celular_cliente"];
    $valor_cuenta=$_POST["valor_cuenta"];
    //id_usuario que crea al vendedor
    $id_usuario = $_POST["id_usuario"];

    $conn->creaUsuarioCliente($cedula_cliente, $nombre_cliente, $apellido_cliente, $correo_cliente, $direccion_cliente, $telefono_cliente, $celular_cliente,$valor_cuenta);

    //Tomamos el id del cliente creado
    $id_cliente = $conn->conexion->query("select id_cliente from cliente order by id_cliente desc limit 1");
    $id = $id_cliente->fetch_array();
    $cliente_id = $id[0];
    
    //asignamos el cliente creado al usuario
    $conn->asignaClienteUsuario($id_usuario, $cliente_id);
    
    $conn->cerrar();
}