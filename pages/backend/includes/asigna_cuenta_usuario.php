<?php

session_start();
if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $id_cuentas = $_POST["id_cuentas"];
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

    $conn->cerrar();
}

