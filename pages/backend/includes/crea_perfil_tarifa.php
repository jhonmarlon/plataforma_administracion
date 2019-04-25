<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $id_usuario = $_POST["id_usuario"];
    $codigo=$_POST["codigo"];

    //tomamos los datos del temporal
    $datos = $conn->getPerfilTarifaTemporal($id_usuario, "crea");

    // $datos = $datos->fetch_assoc();
    $ultimo_id=0;
    $aux = 0;
    while ($dato = $datos->fetch_assoc()) {

        if ($aux == 0) {
            $nombre_perfil = $dato["nombre_perfil"];
            $id_usuario = $dato["id_usuario"];
            $id_empresa = $dato["id_empresa"];
            //creamos el registro en la tarifa
            $conn->creaPerfilTarifa($nombre_perfil, $id_usuario, $id_empresa,$codigo);
            //tomamos el ultimo id generado
            $ultimo_id=$conn->ejecutar_consulta_simple("SELECT id FROM perfil_tarifa_empresa "
                    . "ORDER BY id DESC LIMIT 1");
            $ultimo_id=$ultimo_id->fetch_array();
            $ultimo_id=$ultimo_id[0];
            $aux++;
        }
        
        //generamos el registro de los servicios del perfil
        $conn->creaRegistroTarifaServicio($dato["id_servicio"],$dato["tarifa"],$ultimo_id);
        //eliminamos datos del temporal
        $conn->ejecutar_consulta_simple("DELETE FROM perfil_tarifa_temporal WHERE id_usuario='$id_usuario'");
        
    }
    


    //  $conn->creaPerfilTarifa($nombre_perfil, $id_usuario, $id_empresa, $id_servicio, $tarifa);

    $conn->cerrar();
}
         