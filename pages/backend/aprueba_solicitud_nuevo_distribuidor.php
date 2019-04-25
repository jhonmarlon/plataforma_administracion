<?php
session_start();


if ($_SESSION ['authenticated'] == 1) {
    include '../../modelo/conexion.php';
    $conn = new conexion();
    
    $id_usuario=$_POST["id_usuario"];
    $id_distribuidor=$_POST["id_distribuidor"];
    
    //tomamos los valores de la tabla temporal y los llevamos a la tabla 
    //credito_usuario_servicio
    $temporal=$conn->ejecutar_consulta_simple("SELECT * FROM usuario_tarifa_servicio_temp WHERE "
            . "id_usuario_resp='$id_usuario' AND id_usuario_aprobar='$id_distribuidor'");
    
    //ingresamos los datos a la tabla
    while($temp=$temporal->fetch_assoc()){
        
        $conn->ejecutar_consulta_simple("INSERT INTO credito_usuario_servicio (id_usuario_resp,id_usuario_aprobar,"
                . "id_servicio,monto_permitido_venta) VALUES ('".$temp["id_usuario_resp"]."','".$temp["id_usuario_aprobar"]."',"
                . "'".$temp["id_servicio"]."','".$temp["monto_permitido_venta"]."')");
        
    }
    
    //eliminamos datos de la tabla temporal
    $conn->ejecutar_consulta_simple("DELETE FROM usuario_tarifa_servicio_temp WHERE "
            . "id_usuario_resp='$id_usuario' AND id_usuario_aprobar='$id_distribuidor'");
    
    //obtenemos los datos del usuario aprobado para mostrarlos en el modal
    $datos_usuario_aprobado=$conn->ejecutar_consulta_simple("SELECT nombre,apellido,correo,clave FROM usuarios WHERE "
            . "id='$id_distribuidor'");
    
    $datos=$datos_usuario_aprobado->fetch_assoc();
    $mensaje="";
    $mensaje.= "<b>Nombre Usuario: </b><label id='nombre_usuario_aprobado'>".$datos["nombre"]." ".$datos["apellido"]."</label><br>";
    $mensaje.="<b>Correo: </b><label id='correo_usuario_aprobado'>".$datos["correo"]."</label><br>";
    $mensaje.="<b>Contraseña: </b><label id='clave_usuario_aprobado'>".$conn->decryption($datos["clave"])."</label><br>";

    echo $mensaje;
    
    //cambiamos el estado del usuario
    $conn->ejecutar_consulta_simple("UPDATE usuarios SET estado='A' WHERE id='$id_usuario'");
    
    //cambiamos el estado del credito correspondiente al usuario
    $conn->ejecutar_consulta_simple("UPDATE credito_usuario SET estado='A' WHERE id_usuario='$id_usuario'");
}
        
?>


