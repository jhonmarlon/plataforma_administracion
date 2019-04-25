<?php

session_start();
if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();
    $id_cuentas = $_POST["id_cuentas"];
    $id_cliente = $_POST["id_cliente"];
    $id_usuario = $_POST["id_usuario"];

    $abono = $_POST["abono"];
    $tipo_pago = $_POST["tipo_pago"];

    //Quitamos la ultima coma
    $id_cuentas = trim($id_cuentas, ',');
    //separamos por coma para crear arreglo
    $miarreglo_cuentas = explode(',', $id_cuentas);
    //contamos el número de cuentas
    $num_cuentas = count($miarreglo_cuentas);
    //fecha actual de asignacion
    setlocale(LC_TIME, 'es_ES.utf8', 'esp');
    date_default_timezone_set('America/Bogota');
    $fecha = strftime("%Y-%m-%d %H:%M:%S");
    //tomamos el valor unitario de las cuentas para el cliente
    $valor_cuenta = $conn->conexion->query("select valor_cuenta "
            . "from cliente where id_cliente='$id_cliente'");
    $val_cuenta = $valor_cuenta->fetch_array();
    $val = $val_cuenta[0];
    //total a pagar
    $total_pagar = $val * $num_cuentas;
    //ganancia
    $valor_cuenta_usuario = $conn->conexion->query("select valor_cuenta from "
            . "usuario where id_usuario='$id_usuario'");
    $val_cuenta_usu = $valor_cuenta_usuario->fetch_array();
    $val_cuenta_usuario = $val_cuenta_usu[0];

    $ganancia = $total_pagar - ($val_cuenta_usuario * $num_cuentas);

    //validams si es con abono o si no
    if ($tipo_pago == "abono") {
        $monto_pagado = $abono;
        $monto_restado = $total_pagar - $abono;
        $estado='P';
    }else{
        $monto_pagado=$total_pagar;
        $monto_restado = 0;
        $estado='C';
    }

    //Creamos el detalle de la venta en la tabla detalle_cuenta_cliente
    $conn->creaDetalleCuentaCliente($fecha, $num_cuentas, $val, $total_pagar, $ganancia, $monto_pagado,
            $monto_restado,$estado);

    //tomamos el ultimo detalle generado
    $id_detalle = $conn->conexion->query("select id_detalle_cuenta_cliente "
            . "from detalle_cuenta_cliente order by "
            . "id_detalle_cuenta_cliente desc limit 1");
    $detalle = $id_detalle->fetch_array();
    $id_detalle_cliente = $detalle[0];

    //Adignamos las cuentas al cliente y cambiamos el estado de cada una de ellas
    // estado 2 = tomada, estado 1=disponible y activa, estado 0=inactiva
    for ($i = 0; $i < $num_cuentas; $i++) {
        $conn->asignaCuentaClienteFinal($miarreglo_cuentas[$i], $id_cliente, $id_detalle_cliente);
        //cambiamos el estado de las cuenta
        $cuenta = $miarreglo_cuentas[$i];
        $conn->cambiaEstadoCuentaAsignadaCliente($cuenta);
    }


    //Adignamos las cuentas al cliente y cambiamos el estado de cada una de ellas
    //estado 2 = tomada, estado 1=disponible y activa, estado 0=inactiva
    /* for ($i = 0; $i < $num_cuentas; $i++) {
      $conn->asignaCuentaCliente($miarreglo_cuentas[$i], $id_cliente, $fecha);
      //cambiamos el estado de la cuenta
      $cuenta = $miarreglo_cuentas[$i];
      $conn->cambiaEstadoCuentaTomada($cuenta);
      } */

    /* $id_cuentas = $_POST["id_cuentas"];
      $id_vendedor = $_POST["id_vend"];
      //Quitamos la ultima coma
      $id_cuentas = trim($id_cuentas, ',');
      //separamos por coma para crear arreglo
      $miarreglo_cuentas = explode(',', $id_cuentas);
      //contamos el número de cuentas
      $num_cuentas = count($miarreglo_cuentas);
      //fecha actual de asignacion
      setlocale(LC_TIME, 'es_ES.utf8', 'esp');
      date_default_timezone_set('America/Bogota');
      $fecha = strftime("%Y-%m-%d %H:%M:%S");

      //verificamos si el tiene cuentas a disposicion
      $num_cuentas_vendedor = $conn->conexion->query("select num_cuentas "
      . "from usuario where id_usuario='$id_vendedor'");
      $cuentas_vendedor = $num_cuentas_vendedor->fetch_array();
      $cuen_vend = $cuentas_vendedor[0];

      if ($num_cuentas <= $cuen_vend && $cuen_vend >= 0) {

      //Adignamos las cuentas al usuario y cambiamos el estado de cada una de ellas
      // estado 2 = tomada, estado 1=disponible y activa, estado 0=inactiva
      for ($i = 0; $i < $num_cuentas; $i++) {
      $conn->asignaCuentaUsuario($miarreglo_cuentas[$i], $id_vendedor, $fecha,"sin_solicitud");
      //cambiamos el estado de la cuenta
      $cuenta = $miarreglo_cuentas[$i];
      $conn->cambiaEstadoCuentaTomada($cuenta);
      }
      //le restamos al usuario las cuentas que se le han asignado
      $conn->restaCuentas($id_vendedor, ($cuen_vend - $num_cuentas));

      echo "true";
      } else {
      echo "false";
      }

      $conn->cerrar(); */
}

