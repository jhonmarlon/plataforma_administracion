<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $user_id = $_POST["user_id"];
    $usuario_respon = $_POST["usuario_respon"];
    $num_cuentas_compra = $_POST["num_cuentas_compra"];
    $aux_cuentas = $num_cuentas_compra;

    //variable que evalua las cuentas segun hayan disponibles
    $num_cuentas_reales_compradas;

    $valor_cuenta_compra = $_POST["valor_cuenta_compra"];
    $valor_pagar_cuentas_compra = $_POST["valor_pagar_cuentas_compra"];
    //tomamos la fecha actual para tener la fecha de compra
    setlocale(LC_TIME, 'es_ES.utf8', 'esp');
    date_default_timezone_set('America/Bogota');
    $fecha_actual = strftime("%Y-%m-%d %H:%M:%S");

    //verificamos el estado de cuenta del usuario
    $sum_detalle = $conn->getSumDetalle($user_id);
    $suma_detalle = $sum_detalle->fetch_array();

    $aux = 0;
    //verificamos si el usuario es privilegiado
    $privilegiado = $conn->esPrivilegiado($user_id);
    $priv = $privilegiado->fetch_array();

    //verificamos que hayan cuentas en la bd disponibles
    $num_cuentas_reales_compradas = tomaCuentas($num_cuentas_compra, $conn);

    if ($num_cuentas_reales_compradas == 0) {
        return;
    }

    //sacamos el valor total a pagar por las cuentas compradas
    $valor_pagar_cuentas_compra = $valor_cuenta_compra * $num_cuentas_reales_compradas;


    //Si el usuario es provilegiado
    if ($priv[0] != 0) {
        $pri = 1;

        //tomamos los datos de los privilegios del usuario
        $datos_privilegio = $conn->datosPrivilegioVendedor($user_id);
        $datos_pri = $datos_privilegio->fetch_assoc();
        //si no tiene estados de cuenta pendientes
        if ($suma_detalle[0] == 0) {


            //tomamos la cantidad de dias lapso vantas que tiene el usuario privilegiado
            $dias_lapso = $datos_pri["dias_lapso_ventas"];
            //Sumamos a la fecha actual los dias del lapso de tiempo para generar los bloques de detalles 
            //segun el numero de dias que tenga de lapso de tiempo.
            $fecha_lapso_venta = strtotime('+' . $dias_lapso . ' day', strtotime($fecha_actual));
            $fecha_lapso_venta = date('Y-m-d', $fecha_lapso_venta);

            //ponemos la fecha limite segun el numero de dias de plazo que tiene
            //el usuario en la tabla usuario_privilegiado
            $dias_plazo = $datos_pri["dias_plazo"];

            //sumamos a la fecha lapso los dias que tiene de plazo el usuario para realizar el pago
            //para obtener la fecha limite de pago
            $fecha_limite_pago = strtotime('+' . $dias_plazo . ' day', strtotime($fecha_lapso_venta));
            $fecha_limite_pago = date('Y-m-d', $fecha_limite_pago);

            // echo "<script>alert('$fecha_lapso_venta'+' lapso enta')</script>";
            //echo "<script>alert('$dias_lapso'+' dias lapso')</script>";
            //echo "<script>alert('$dias_plazo'+' dias plazo')</script>";
            // echo "<script>alert('$fecha_limite_pago'+' limite pago')</script>";
            //creamos el detalle en la base de datos
            $conn->creaDetalleVendedorPrivilegiado($user_id, $usuario_respon, $num_cuentas_reales_compradas, $valor_cuenta_compra, $valor_pagar_cuentas_compra, $fecha_actual, $fecha_lapso_venta, $fecha_limite_pago);
            //Una vez creamos el detalle ,tomamos su id, para poder crear el registro
            // enla tabla cuenta_usuario
            $id_detalle_cuenta_usuario = $conn->getIdDetalleCuentaUsuarioPri();
            $id_detalle = $id_detalle_cuenta_usuario->fetch_array();

            //cambiamos el estado de las cuentas
            $aux = cambiaEstadoCuenta($conn, $num_cuentas_reales_compradas, $user_id, $fecha_actual, $id_detalle, $pri);

            //restamos el monto usado al monto actual del usuario que realizò la compra.
            $saldo_act = $conn->getSaldoActual($user_id);
            $saldo = $saldo_act->fetch_array();

            $saldo_restado = $saldo[0] - $valor_pagar_cuentas_compra;
            $conn->restaSaldoActualUsuario($saldo_restado, $user_id);

            muestraMensaje($aux, $aux_cuentas);
        } else {

            //validamos que el estado de cuenta del cliente o la deuda,
            //sea menor al maximo permitido + 10%
            //Si el estado de cuenta es menor al monto permitido de saldo + 10%,
            //la compra se realiza automaticamente
            $saldo_max_perm = $datos_pri["saldo_maximo_permitido"];
            //$saldo_max_permitido = $saldo_max_perm->fetch_array();
            $saldo_mas_porciento = $saldo_max_perm + ($saldo_max_perm * 0.1);

            //validamos que el estado de cuenta , sea menos al saldpo permitido + 10%
            if ($suma_detalle[0] >= $saldo_mas_porciento) {
                echo "<script> 
                  alertify.alert('<P align=center><b><font color=red>IMPORTANTE</font>'+
                  '<p>Antes de realizar la compra de las cuentas, es necesario que se ponga a paz y salvo, o realice un abono, le sugerimos que revise su estado de cuenta para más información.<p>'+
                  ' Comuníquese con su proveedor o directamente con la administración, de lo contrario, '+
                  '<font color=red>NO</font> podrá realizar las compras correctamente.', 
                  function () {

                            window.setTimeout('location.reload()');
                        });
            </script>";

                return;
            }

            //si el detalle existe pero es menor que el maximo permitido mas el 10%
            //tomamos el ultimo detalle generado que tenga el usuario y verificamos si
            //la compra se realiza antes de que se cumpla el lapso de ventas.
            $lapso_ultimo_detalle = $conn->getUltimoDetalleUsuarioPri($user_id);
            $lapso_ult_detalle = $lapso_ultimo_detalle->fetch_assoc();

            //Si la fecha de compra actual es menor al lapso de venta
            if ($fecha_actual <= $lapso_ult_detalle["fecha_lapso_venta"]) {
                //generamos el detalle en la base de datos
                $conn->creaDetalleVendedorPrivilegiado($user_id, $usuario_respon, $num_cuentas_reales_compradas, $valor_cuenta_compra, $valor_pagar_cuentas_compra, $fecha_actual, $lapso_ult_detalle["fecha_lapso_venta"], $lapso_ult_detalle["fecha_limite_pago"]);

                //Una vez creamos el detalle ,tomamos su id, para poder crear el registro
                // en la tabla cuenta_usuario
                $id_detalle_cuenta_usuario = $conn->getIdDetalleCuentaUsuarioPri();
                $id_detalle = $id_detalle_cuenta_usuario->fetch_array();

                //cambiamos el estado de las cuentas
                $aux = cambiaEstadoCuenta($conn, $num_cuentas_reales_compradas, $user_id, $fecha_actual, $id_detalle, $pri);

                //restamos el monto usado al monto actual del usuario que realizò la compra.
                $saldo_act = $conn->getSaldoActual($user_id);
                $saldo = $saldo_act->fetch_array();

                $saldo_restado = $saldo[0] - $valor_pagar_cuentas_compra;
                $conn->restaSaldoActualUsuario($saldo_restado, $user_id);

                muestraMensaje($aux, $aux_cuentas);
            } else {
                //si la fecha actual es mayor a la fecha de lapso
                //tomamos la cantidad de dias lapso vantas que tiene el usuario privilegiado
                $dias_lapso = $datos_pri["dias_lapso_ventas"];
                //tomamos la cantidad de dias que tiene el usuario de plazo para realizar pagos
                $dias_plazo = $datos_pri["dias_plazo"];
                //suamos a la fecha actual los dias de lapso
                $fecha_lapso_venta = strtotime('+' . $dias_lapso . ' day', strtotime($fecha_actual));
                //sumamos a la fecha lapso los dias de plazo , para poder tener la fecha limite
                $fecha_limite_pago = strtotime('+' . $dias_plazo . ' day', strtotime($fecha_lapso_venta));


                //generamos el detalle en la base de datos
                $conn->creaDetalleVendedorPrivilegiado($user_id, $usuario_respon, $num_cuentas_reales_compradas, $valor_cuenta_compra, $valor_pagar_cuentas_compra, $fecha_actual, $fecha_lapso_venta, $fecha_limite_pago);

                //Una vez creamos el detalle ,tomamos su id, para poder crear el registro
                // enla tabla cuenta_usuario
                $id_detalle_cuenta_usuario = $conn->getIdDetalleCuentaUsuarioPri();
                $id_detalle = $id_detalle_cuenta_usuario->fetch_array();

                //cambiamos el estado de las cuentas
                $aux = cambiaEstadoCuenta($conn, $num_cuentas_reales_compradas, $user_id, $fecha_actual, $id_detalle, $pri);

                //restamos el monto usado al monto actual del usuario que realizò la compra.
                $saldo_act = $conn->getSaldoActual($user_id);
                $saldo = $saldo_act->fetch_array();

                $saldo_restado = $saldo[0] - $valor_pagar_cuentas_compra;
                $conn->restaSaldoActualUsuario($saldo_restado, $user_id);

                muestraMensaje($aux, $aux_cuentas);
            }
        }
    } else {
        //usuario no privilegiado
        $pri = 0;

        //asignamos las cuentas segun el numero de cuentas pedido
        //creamos el detalle de la compra;
        $conn->creaDetalleVendedor($user_id, $usuario_respon, $num_cuentas_reales_compradas, $valor_cuenta_compra, $valor_pagar_cuentas_compra, $fecha_actual);

        //Una vez creamos el detalle ,tomamos su id, para poder crear el registro
        // enla tabla cuenta_usuario
        $id_detalle_cuenta_usuario = $conn->getIdDetalleCuentaUsuario();
        $id_detalle = $id_detalle_cuenta_usuario->fetch_array();

        //cambiamos el estado de las cuentas
        $aux = cambiaEstadoCuenta($conn, $num_cuentas_reales_compradas, $user_id, $fecha_actual, $id_detalle, $pri);

        //restamos el monto usado al monto actual del usuario que realizò la compra.
        $saldo_act = $conn->getSaldoActual($user_id);
        $saldo = $saldo_act->fetch_array();

        $saldo_restado = $saldo[0] - $valor_pagar_cuentas_compra;
        $conn->restaSaldoActualUsuario($saldo_restado, $user_id);

        muestraMensaje($aux, $aux_cuentas);
    }
}

function tomaCuentas($num_cuentas_compra, $conn) {
    //tomamos las cuentas segun el numero pedido

    $cuenta = $conn->getCuentasNetflixAct();
    $num = mysqli_num_rows($cuenta);

    if ($num == 0) {

        echo "<script> alertify.alert('<b>No hay cuentas disponibles actualmente, inténtalo mas tarde.</b>');
            </script>";
        return 0;
    }
    //una vez se revise cuantas cuentas hay en la bd , creamos el detalle
    //con las que hayan disponibles
    if ($num_cuentas_compra > $num) {
        $num_cuentas_reales = $num;
    } else {
        $num_cuentas_reales = $num_cuentas_compra;
    }
    return $num_cuentas_reales;
}

function cambiaEstadoCuenta($conn, $num_cuentas_reales_compradas, $user_id, $fecha_actual, $id_detalle, $pri) {
    //tomamos numero de cuentas disponibles
    if ($pri == '1') {
        $tipo_cliente = 'Privilegiado';
    } else {
        $tipo_cliente = 'Mayorista';
    }
    $aux = 0;
    $cuentas_net = $conn->getCuentasNetflixAct();

    //cambiamos el estado de las cuentas
    while ($cuenta_net = $cuentas_net->fetch_assoc()) {
        //Asignamos las cuentas al usuario segun als que haya comprado
        if ($aux < $num_cuentas_reales_compradas) {
            $conn->asignaCuentaNetActUsuario($cuenta_net['id_cuenta_netflix_act'], $user_id, $fecha_actual, $tipo_cliente, $id_detalle[0], "1");
            //cambiamos el estado de las ceuntas
            $conn->cambiaEstadoCuentaTomada($cuenta_net['id_cuenta_netflix_act']);
            $aux += 1;
        }
    }
    return $aux;
}

function muestraMensaje($aux, $aux_cuentas) {

    echo "<script> 
                  alertify.alert('<P align=center><b><font color=red>COMPRA REALIZADA</font>'+
                  '<p>Se le han asignado <font color=red>'+$aux+'</font>'+
                  ' Cuenta(s) de '+$aux_cuentas+' que solicitó.<p> Tus cuentas '+
                  'se almacenarán en el buzón de cuentas del tablero de contról.', 
                  function () {

                            window.setTimeout('location.reload()');
                        });
            </script>";
}
