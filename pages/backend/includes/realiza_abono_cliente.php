<?php

session_start();

if ($_SESSION["authenticated"] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();


    $id_usuario = $_POST["id_usuario"];
    $id_cliente = $_POST["id_cliente"];
    $total = $_POST["total"];
    $monto_abonado = $_POST["monto_abonado"];

    //tomamos la fecha actual para tener la fecha del registro de abono
    setlocale(LC_TIME, 'es_ES.utf8', 'esp');
    date_default_timezone_set('America/Bogota');
    $fecha_actual = strftime("%Y-%m-%d %H:%M:%S");


    $detalle_cliente = $conn->getDetalleCuentaCliente($id_cliente);
    $detalle_cliente_abona = $conn->getDetalleCuentaCliente($id_cliente);
    //$detalle_cliente_abona = $conn->getDetalleCuentaVendedor($id_vendedor, $tipo_vendedor);
    //Realizamos registro del abono
    $monto_acumulado = 0;
    while ($monto_debe = $detalle_cliente->fetch_assoc()) {

        $monto_acumulado += $monto_debe["monto_restado"];
    }

    $monto_resta = $monto_acumulado - $monto_abonado;

    $conn->creaRegistroAbonoCliente($id_cliente, $id_usuario, $monto_acumulado, $monto_abonado, $monto_resta, $fecha_actual);

    //Actualizamos los detalles en la tabla
    while ($res = $detalle_cliente_abona->fetch_assoc()) {

        if ($monto_abonado != 0) {
            if (($monto_abonado > $res["monto_restado"]) && ($res["total"] > 0)) {
                //echo $monto_abonado . " es mayor a " . $res["total_pagar"];
                $monto_abonado -= $res["total"];
                //cambiamos el total a pagar por cero y cambiamos estado de detalle
                $conn->actualizaDetalleCliente($res["id_detalle_cuenta_cliente"], 0);
                $conn->cambiaEstadoDetalleCliente($res["id_detalle_cuenta_cliente"]);
                //echo $monto_abonado . " Nuevo monto";
            } elseif (($monto_abonado < $res["total"]) && ($res["total"] > 0)) {
                //echo $monto_abonado . " es menor a " . $res["total_pagar"];
                $restante = $res["total"] - $monto_abonado;
                //cambiamos el total a pagar por el restante
                $conn->actualizaDetalleCliente($res["id_detalle_cuenta_cliente"], $restante);

                $monto_abonado = 0;

                //echo "el nuevo monto es" . $monto_abonado;
            } elseif (($monto_abonado == $res["total"]) && ($res["total"] > 0)) {
                //cambiamos el total a pagar por cero y cambiamos estado de detalle
                $conn->actualizaDetalleCliente($res["id_detalle_cuenta_cliente"], 0);
                $conn->cambiaEstadoDetalleCliente($res["id_detalle_cuenta_cliente"]);

                $monto_abonado = 0;
            }
        }
    }
    $conn->cerrar();
}
