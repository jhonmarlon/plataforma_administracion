<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {
    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $tipo_vendedor = $_POST['tipo_vendedor'];
    $nombre_usuario = $_POST["nombre_usuario"];
    $apellido_usuario = $_POST["apellido_usuario"];
    $cedula_usuario = $_POST["cedula_usuario"];
    $correo_usuario = $_POST["correo_usuario"];
    $clave_usuario = "Inicial2018*";
    $telefono_usuario = $_POST["telefono_usuario"];
    $celular_usuario = $_POST["celular_usuario"];
    $valor_cuenta_usuario = $_POST["valor_cuenta_usuario"];
    $saldo_inicial = $_POST["saldo_inicial"];

    $saldo_max_permitido = $_POST['saldo_max_permitido'];
    $dias_plazo = $_POST['dias_plazo'];
    $lapso_venta = $_POST['lapso_venta'];
    
    //id_usuario que crea al vendedor
    $id_usuario = $_POST["id_usuario"];

    $conn->creaUsuarioVendedor($cedula_usuario, $nombre_usuario, $apellido_usuario, $correo_usuario, $clave_usuario, $telefono_usuario, $celular_usuario, $valor_cuenta_usuario, $saldo_inicial);

    // Tomamos el id del usuario creado
    $id_user = $conn->conexion->query("select id_usuario from usuario order by id_usuario desc limit 1");
    $id = $id_user->fetch_array();
    $cliente_id = $id[0];
    
    //asignamos el cliente creado al usuario
    $conn->asignaVendedorUsuario($id_usuario, $cliente_id);

    //si s un usuario privilegiado , creamos el registro en usuario_privilegiado
    if ($tipo_vendedor == 'privilegiado') {
        //tomamos variables de usuario privilegiago
      $conn->creaUsuarioVendedorPrivilegiado($cliente_id, $saldo_max_permitido, $dias_plazo,$lapso_venta);
    }


    $conn->cerrar();
}