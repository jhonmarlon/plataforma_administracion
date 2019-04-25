<?php

session_start();

if ($_SESSION["authenticated"] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();
   
    $fecha_limite=$_POST["fecha_limite"];
    $id_usuario = $_POST["id_usuario"];
    $id_vendedor = $_POST["id_vendedor"];
    //$total = $_POST["total"];
    $monto_acumulado=$_POST["monto_debe"];
    $monto_abonado = $_POST["monto_abonado"];
    //define si es vendedor privilegiado o no
    $tipo_vendedor = $_POST["tipo_vendedor"];
    

    //tomamos la fecha actual para tener la fecha del registro de abono
    setlocale(LC_TIME, 'es_ES.utf8', 'esp');
    date_default_timezone_set('America/Bogota');
    $fecha_actual = strftime("%Y-%m-%d %H:%M:%S");

    $detalle_vendedor_abona = $conn->getDetalleCuentaVendedorFecha($id_vendedor, $tipo_vendedor,$fecha_limite);

    echo "monto acumulado: ".$monto_acumulado;
    $monto_resta = $monto_acumulado - $monto_abonado;
    
    //crea el registro del abono
    $conn->creaRegistroAbono($id_vendedor, $id_usuario, $monto_acumulado, $monto_abonado, $monto_resta, $fecha_actual);

    //Actualizamos los detalles en la tabla
    while ($res = $detalle_vendedor_abona->fetch_assoc()) {

        if ($monto_abonado != 0) {
            if (($monto_abonado > $res["total_pagar"]) && ($res["total_pagar"] > 0)) {
                //echo $monto_abonado . " es mayor a " . $res["total_pagar"];
                $monto_abonado -= $res["total_pagar"];
                //cambiamos el total a pagar por cero y cambiamos estado de detalle
                $conn->actualizaDetalleVendedor($res["id_detalle_cuenta_usuario_pri_act"], 0);
                $conn->cambiaEstadoDetalleVendedor($res["id_detalle_cuenta_usuario_pri_act"]);
                //echo $monto_abonado . " Nuevo monto";
            } elseif (($monto_abonado < $res["total_pagar"]) && ($res["total_pagar"] > 0)) {
                //echo $monto_abonado . " es menor a " . $res["total_pagar"];
                $restante = $res["total_pagar"] - $monto_abonado;
                //cambiamos el total a pagar por el restante
                $conn->actualizaDetalleVendedor($res["id_detalle_cuenta_usuario_pri_act"], $restante);

                $monto_abonado = 0;

                //echo "el nuevo monto es" . $monto_abonado;
            } elseif (($monto_abonado == $res["total_pagar"]) && ($res["total_pagar"] > 0)) {
                //cambiamos el total a pagar por cero y cambiamos estado de detalle
                $conn->actualizaDetalleVendedor($res["id_detalle_cuenta_usuario_pri_act"], 0);
                $conn->cambiaEstadoDetalleVendedor($res["id_detalle_cuenta_usuario_pri_act"]);

                $monto_abonado = 0;
                //echo $monto_abonado . " es igual " . $res["total_pagar"];
            }
        }
    }
    $conn->cerrar();
}
